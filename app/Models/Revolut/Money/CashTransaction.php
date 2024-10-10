<?php

namespace App\Models\Revolut\Money;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class CashTransaction extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash',
        'date',

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
}
