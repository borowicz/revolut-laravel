<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;
use App\Models\Revolut\Stock\StockTicker;

class StockMarket extends AbstractRevolutModel
{
    protected $fillable = [
        'disabled',
        'name',
        'short_name',
        'symbol',
        'suffix',
        'suffix_ft',
        'suffix_bb',
        'suffix_gf',
//        'suffix_yf',
//        'suffix_cn',
        'country',
        'currency',
    ];

    public function tickers(): HasMany
    {
        return $this->hasMany(StockTicker::class);
    }

    public function getMarketsList()
    {
        $query = self::query()->select('id')
            ->addSelect(...$this->fillable)
            ->where('disabled', 0)
            ->orderBy('name');

        return $query;
    }
}
