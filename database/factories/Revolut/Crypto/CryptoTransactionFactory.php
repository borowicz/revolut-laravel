<?php

namespace Database\Factories\Revolut\Crypto;

use App\Models\Revolut\Crypto\CryptoTransaction;
use Database\Factories\Revolut\AbstractRevolut;

class CryptoTransactionFactory extends AbstractRevolut
{
    protected $model = CryptoTransaction::class;

    public function definition()
    {
        return [
            'hash',
            'date',
            'symbol',
            'type',
            'currency',
            'quantity',
            'quantity_raw',
            'price',
            'price_raw',
            'value',
            'value_raw',
            'fees',
            'fees_raw',
        ];
    }
}
