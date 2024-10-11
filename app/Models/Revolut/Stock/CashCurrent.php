<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Revolut\AbstractRevolutModel;

class CashCurrent extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes, HasTimestamps;

    protected $table = 'stock_cash';

    protected $fillable = [
        'date',
        'total',
        'note',
    ];
}
