<?php

namespace App\Models\Revolut;

abstract class AbstractTransactions extends AbstractRevolutModel
{
    public static function getTickers()
    {
        return self::query()
            ->select('currency')
            ->distinct('currency')
            ->where('currency', '!=', '')
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
