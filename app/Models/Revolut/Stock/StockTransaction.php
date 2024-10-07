<?php

namespace App\Models\Revolut\Stock;

use App\Models\Revolut\CurrencyExchanges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;
use Illuminate\Support\Facades\DB;

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

    public static function getCashTopUp(string $currencyTo = 'USDEUR')
    {
        $tableCurrency = (new CurrencyExchanges)->getTable();
        $tableStock = (new self)->getTable();

        $query = self::query()
            ->addSelect($tableStock . '.*')
            ->addSelect($tableCurrency . '.*')
            ->join(
                $tableCurrency,
                DB::raw('(DATE_FORMAT(' . $tableStock . '.date, "%Y-%m-%d"))'),
                '=',
                DB::raw('(DATE_FORMAT(' . $tableCurrency . '.when, "%Y-%m-%d"))')
            )
            ->where($tableStock . '.type', 'LIKE', '%cash%')
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
