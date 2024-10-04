<?php

namespace App\Models\Revolut\StockRobo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

/**
 *- -***
 */
class StockRoboTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

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
