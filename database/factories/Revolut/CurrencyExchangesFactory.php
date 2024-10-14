<?php

namespace Database\Factories\Revolut;

use App\Models\Revolut\CurrencyExchanges;
use Illuminate\Support\Str;

class CurrencyExchangesFactory extends AbstractRevolut
{
    protected $model = CurrencyExchanges::class;

    public function definition()
    {
        return [
            'source' => $this->faker->word, // Random word for source
            'hash' => Str::random(40), // Random 40-character hash
            'date' => $this->faker->date, // Random date
            'currency' => $this->faker->currencyCode, // Random currency code
            'code' => $this->faker->regexify('[A-Z]{3}'), // Random 3-letter code
            'exchange_rate' => $this->faker->randomFloat(6, 0.5, 1.5), // Random exchange rate between 0.5 and 1.5
        ];
    }
}
