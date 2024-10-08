<?php

namespace App\Models\Revolut\Crypto;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class CryptoTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash',
        'date',
        'symbol',
        'type',
        'currency',
        'quantity',

        'price',
        'price_raw',
        'value',
        'value_raw',
        'fees',
        'fees_raw',
    ];

    public static function getTickers(bool $all = false)
    {
        $results = self::query()
            ->select('symbol')
            ->distinct()
            ->where('symbol', '!=', '')
            ->whereNotNull('symbol')
            ->orderBy('symbol')
            ->get()
            ->pluck('symbol')
            ->toArray();

        return $results;
    }

    public static function getTypes()
    {
        return self::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->get()
            ->pluck('type')
            ->toArray();
    }
}
