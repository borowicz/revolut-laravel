<?php

namespace App\Models\Revolut;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends AbstractRevolutModel
{
    use HasFactory;

    protected $fillable = [
        'disabled',
        'currency_code',
        'name',
        'symbol',
    ];
}
