<?php

namespace Database\Factories\Revolut\Stock;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Stock\StockProfitLossTransaction;
use Illuminate\Support\Str;

class StockProfitLossTransactionFactory extends AbstractRevolut
{
    protected $model = StockProfitLossTransaction::class;

    public function definition()
    {
        return [
            'hash' => Str::random(40), // Random 40-character hash
            'date_acquired' => $this->faker->date, // Random date for date acquired
            'date_sold' => $this->faker->date, // Random date for date sold
            'symbol' => $this->faker->word, // Random word for symbol
            'security_name' => $this->faker->word, // Random word for security name
            'isin' => $this->faker->regexify('[A-Z]{2}[A-Z0-9]{9}[0-9]'), // Random ISIN
            'country' => $this->faker->countryCode, // Random country code
            'quantity' => $this->faker->randomFloat(2, 1, 1000), // Random quantity between 1 and 1000
            'cost_basis' => $this->faker->randomFloat(2, 0, 10000), // Random cost basis between 0 and 10000
            'gross_proceeds' => $this->faker->randomFloat(2, 0, 10000), // Random gross proceeds between 0 and 10000
            'gross_pnl' => $this->faker->randomFloat(2, -10000, 10000), // Random gross PnL between -10000 and 10000
            'currency' => $this->faker->currencyCode, // Random currency code
        ];
    }
}
