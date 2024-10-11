<?php

namespace App\Models\Revolut\Commodities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class CommoditiesTicker extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'disabled',
            'hash',

            'ticker',
            'url',
            'notes',
        ];
}
