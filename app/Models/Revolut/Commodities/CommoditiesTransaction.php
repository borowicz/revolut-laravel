<?php

namespace App\Models\Revolut\Commodities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class CommoditiesTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable
        = [
            'hash',
            'type',
            'product',
            'started_date',
            'completed_date',
            'description',
            'amount',
            'fee',
            'currency',
            'state',
            'balance',
        ];

    public static function getTickers()
    {
        return self::query()
            ->select('currency')
            ->distinct('currency')
            ->where('currency', '!=', '')
//            ->where('currency', '!=', '')
            ->whereNotNull('currency')
            ->orderBy('currency')
            ->pluck('currency')
            ->toArray();
    }

    public static function getTypes()
    {
        return self::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type')
            ->toArray();
    }
}
