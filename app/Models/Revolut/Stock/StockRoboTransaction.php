<?php

namespace App\Models\Revolut\Stock;

use App\Models\Revolut\AbstractTransactions;

/**
 *- -***
 */
class StockRoboTransaction extends AbstractTransactions
{
    protected $fillable = [
        'hash',
        'date',
        'ticker',
        'type',
        'quantity',
        'price',
        'total',
        'currency',
        'rate',
    ];
}
