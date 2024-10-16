<?php

namespace Database\Factories\Revolut\Money;

use App\Models\Revolut\Money\CashTransaction;
use Database\Factories\Revolut\AbstractRevolut;
use Illuminate\Support\Str;

class CashTransactionFactory extends AbstractRevolut
{
    protected $model = CashTransaction::class;

    public function definition()
    {
        return [
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
}
