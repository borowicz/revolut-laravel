<?php

namespace App\Models\Revolut\Crypto;

use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;
use Illuminate\Support\Facades\DB;

class CryptoTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable
        = [
            'hash',
            'date',
            'symbol',
            'type',
            'currency',
            'quantity',
            'quantity_raw',
            'price',
            'price_raw',
            'value',
            'value_raw',
            'fees',
            'fees_raw',
        ];

    public static function getTickersList()
    {
        return self::query()
            ->select('symbol', 'currency')
            ->distinct('symbol')
            ->where('symbol', '!=', '')
            ->where('currency', '!=', '')
            ->whereNotNull('symbol');;
    }

    public static function getSummary(bool $all = true)
    {
        $sell = $withdrawal = StockCalculations::TYPE_SELL;
        $query = DB::table((new self())->getTable())
            ->selectRaw(
                '
                symbol,
                (
                    SUM(CASE WHEN type NOT LIKE "%' . $sell . '%" THEN quantity ELSE 0 END)
                    - SUM(CASE WHEN type LIKE "%' . $sell . '%" THEN quantity ELSE 0 END)
                ) AS total
            '
            )
            ->groupBy('symbol')
            ->orderBy('total', 'DESC')
            ->orderBy('symbol');

        if (!$all) {
            $query->having('total', '>', 0);
        }

        return $query;
    }

    public static function getTickers(bool $all = false)
    {
        return self::query()
            ->select('symbol')
            ->distinct()
            ->where('symbol', '!=', '')
            ->whereNotNull('symbol')
            ->orderBy('symbol')
            ->pluck('symbol')
            ->toArray();
    }

    public static function getTypesSummary()
    {
        return self::query()
            ->selectRaw('type, COUNT(id) as cnt')
            ->groupBy('type')
            ->orderBy('type')
            ->get()
            ->toArray();
    }

    public static function getTypes()
    {
        return self::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type')
            ->toArray();
    }
}
