<?php

namespace Database\Factories\Revolut\Stock;

use App\Models\Revolut\Stock\StockRoboTransaction;
use Database\Factories\Revolut\AbstractRevolut;
use Illuminate\Support\Str;

/**
 *- -***
 */
class StockRoboTransactionFactory extends AbstractRevolut
{
    protected $model = StockRoboTransaction::class;

    public function definition()
    {
        return [
            'hash' => Str::random(40), // Random 40-character hash
            'date' => $this->faker->date, // Random date
            'ticker' => $this->faker->word, // Random word for ticker
            'type' => $this->faker->randomElement(['buy', 'sell']), // Randomly 'buy' or 'sell'
            'quantity' => $this->faker->randomFloat(2, 1, 1000), // Random quantity between 1 and 1000
            'price' => $this->faker->randomFloat(2, 0, 1000), // Random price between 0 and 1000
            'total' => $this->faker->randomFloat(2, 0, 1000000), // Random total amount between 0 and 1000000
            'currency' => $this->faker->currencyCode, // Random currency code
            'rate' => $this->faker->randomFloat(4, 0.5, 1.5), // Random rate between 0.5 and 1.5
        ];
    }
}
