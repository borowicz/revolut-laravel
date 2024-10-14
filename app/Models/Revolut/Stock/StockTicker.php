<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class StockTicker extends AbstractRevolutModel
{
    protected $fillable = [
        'disabled',
        'hash',
        'stock_markets_id',
        'ticker',
        'url',
        'notes',
    ];

    public function stockMarket()
    {
        return $this->belongsTo(StockMarket::class, 'stock_markets_id');
    }
}
