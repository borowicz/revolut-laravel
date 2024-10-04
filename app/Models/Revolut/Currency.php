<?php

namespace App\Models\Revolut;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends AbstractRevolutModel
{
    use HasFactory;

    protected $fillable = [
        'source',
        'hash',
        'when',
        'currency',
        'code',
        'exchange_rate',
    ];

    public static function getExchangeCurrencies()
    {
        $results = self::query()
            ->select('currency', 'code')
            ->distinct('code')
            ->orderBy('code')
            ->get()
            ->toArray();

        return $results;
    }
}
