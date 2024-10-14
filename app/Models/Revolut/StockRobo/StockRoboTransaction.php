<?php

namespace App\Models\Revolut\StockRobo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
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
