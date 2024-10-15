<?php

namespace Database\Factories\Revolut\Stock;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Stock\StockProfitLossOtherTransaction;
use Illuminate\Support\Str;

class StockProfitLossOtherTransactionFactory extends AbstractRevolut
{
    protected $model = StockProfitLossOtherTransaction::class;

    public function definition()
    {
        return [
            'hash' => Str::random(40), // Random 40-character hash
            'date' => $this->faker->date, // Random date
            'symbol' => $this->faker->word, // Random word for symbol
            'security_name' => $this->faker->word, // Random word for security name
            'isin' => $this->faker->regexify('[A-Z]{2}[A-Z0-9]{9}[0-9]'), // Random ISIN
            'country' => $this->faker->countryCode, // Random country code
            'gross_amount' => $this->faker->randomFloat(2, 0, 10000), // Random gross amount between 0 and 10000
            'withholding_tax' => $this->faker->randomFloat(2, 0, 1000), // Random withholding tax between 0 and 1000
            'net_amount' => $this->faker->randomFloat(2, 0, 9000), // Random net amount between 0 and 9000
            'currency' => $this->faker->currencyCode, // Random currency code
        ];
    }
}
