<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class StockTicker extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'disabled',
        'hash',
        'stock_markets_id',
        'ticker',
        'url',
        'notes',
    ];
}
