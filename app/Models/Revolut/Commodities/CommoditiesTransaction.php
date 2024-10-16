<?php

namespace App\Models\Revolut\Commodities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractTransactions;
use Illuminate\Support\Facades\DB;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;

class CommoditiesTransaction extends AbstractTransactions
{
    protected $fillable = [
            'hash',
            'type',
            'product',
            'started_date',
            'completed_date',
            'description',
            'amount',
            'amount_raw',
            'fee',
            'fee_raw',
            'currency',
            'state',
            'balance',
            'balance_raw',
        ];

    public static function getTickersList()
    {
        return self::query()
            ->select('currency')
            ->distinct('currency')
            ->where('currency', '!=', '')
            ->whereNotNull('currency');
    }

    public static function getTickers(bool $all = false)
    {
        return self::query()
            ->select('currency as symbol')
            ->distinct()
            ->where('currency', '!=', '')
            ->whereNotNull('currency')
            ->orderBy('currency')
            ->pluck('symbol')
            ->toArray();
    }

    public static function getSummary(bool $all = true)
    {
        $sell = StockCalculations::TYPE_SELL;
        $query = DB::table((new self())->getTable());

        return $query;
    }

    public static function getTypesSummary()
    {
        return self::query()
            ->selectRaw('description as type, COUNT(id) as cnt')
            ->groupBy('description')
            ->orderBy('description')
            ->get()
            ->toArray();
    }
}
