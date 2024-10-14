<?php

namespace App\Models\Revolut\Commodities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractTransactions;

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
}
