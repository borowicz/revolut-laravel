<?php

namespace App\Models\Revolut\Crypto;

use App\Models\Revolut\Stock\StockMarket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class CryptoTicker extends AbstractRevolutModel
{
    protected $fillable = [
        'disabled',
        'hash',

        'ticker',
        'url',
        'notes',
    ];

    public function stockMarket()
    {
        return $this->belongsTo(StockMarket::class, 'stock_markets_id');
    }
}
