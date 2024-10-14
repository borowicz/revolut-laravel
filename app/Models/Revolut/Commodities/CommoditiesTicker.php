<?php

namespace App\Models\Revolut\Commodities;

use App\Models\Revolut\AbstractRevolutModel;

class CommoditiesTicker extends AbstractRevolutModel
{
    protected $fillable = [
            'disabled',
            'hash',

            'ticker',
            'url',
            'notes',
        ];
}
