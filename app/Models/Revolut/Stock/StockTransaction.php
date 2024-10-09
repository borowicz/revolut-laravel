<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Revolut\AbstractRevolutModel;
use App\Models\Revolut\CurrencyExchanges;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;

class StockTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash',
        'date',
        'ticker',
        'type',
        'quantity',
        'price_per_share',
        'total_amount',
        'currency',
        'fx_rate',
    ];

    public static function getTickers(bool $all = false)
    {
        $results = self::query()
            ->select('ticker')
            ->distinct()
            ->where('ticker', '!=', '')
            ->whereNotNull('ticker')
            ->orderBy('ticker')
            ->get()
            ->pluck('ticker')
            ->toArray();

        return $results;
    }

    public static function getTransactionsCash()
    {
        $cash =DB::table((new self())->getTable())
            ->select(
                DB::raw(
                    '(SUM(CASE WHEN type LIKE "%cash top%" THEN total_amount ELSE 0 END)
                - SUM(CASE WHEN type LIKE "%with%" THEN total_amount ELSE 0 END)) AS total'
                )
            )
            ->value('total')
        ;

        return $cash;
    }

    public function getCashTopUp(string $currencyTo = 'USDEUR')
    {
        $cash = StockCalculations::TYPE_CASH;
        $withdrawal = StockCalculations::TYPE_WITHDRAWAL;

        $tableCurrency = (new CurrencyExchanges)->getTable();
        $tableStock = (new self)->getTable();

        $query = self::query()
            ->addSelect($tableStock . '.*')
            ->addSelect($tableCurrency . '.code', $tableCurrency . '.exchange_rate')
            ->leftJoin(
                $tableCurrency,
                DB::raw('(DATE_FORMAT(' . $tableStock . '.date, "%Y-%m-%d"))'),
                '=',
                DB::raw('(DATE_FORMAT(' . $tableCurrency . '.date, "%Y-%m-%d"))')
            )
            ->where($tableStock . '.type', 'LIKE', '%' . $cash . '%')
            ->where($tableCurrency . '.code', '=', $currencyTo);

        return $query;
    }

    public static function getTypes()
    {
        return self::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->get()
            ->pluck('type')
            ->toArray();
    }

    public function scopeSearch($query, $term)
    {
        if ($term) {
            $term = "%$term%";
            $query->where(function($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }
    }
}
