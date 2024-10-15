<?php

namespace Database\Factories\Revolut\Commodities;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Commodities\CommoditiesTransaction;
use Illuminate\Support\Str;

class CommoditiesTransactionFactory extends AbstractRevolut
{
    protected $model = CommoditiesTransaction::class;

    public function definition()
    {
        return [
            'hash' => Str::random(40),
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
}
