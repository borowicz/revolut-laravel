<?php

namespace App\Models\Revolut\Money;

use Illuminate\Support\Facades\DB;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use App\Models\Revolut\AbstractTransactions;

class CashTransaction extends AbstractTransactions
{
    protected $fillable = [
        'hash',
        'date',

        'type',
        'product',
        'started_date',
        'completed_date',
        'description',
        'amount_raw',
        'amount',
        'fee_raw',
        'fee',
        'currency',
        'state',
        'balance_raw',
        'balance',
    ];

    public static function getSummary(bool $all = true)
    {
//        $sell = StockCalculations::TYPE_SELL;
        $query = DB::table((new self())->getTable());
//            ->selectRaw(
//                '
//                currency as symbol,
//                product,
//                (
//                    SUM(CASE WHEN type NOT LIKE "%' . $sell . '%" THEN quantity ELSE 0 END)
//                    - SUM(CASE WHEN type LIKE "%' . $sell . '%" THEN quantity ELSE 0 END)
//                ) AS total
//            '
//            )
//            ->groupBy('symbol')
//            ->orderBy('total', 'DESC')
//            ->orderBy('symbol');
//
//        if (!$all) {
//            $query->having('total', '>', 0);
//        }

        return $query;
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
}
