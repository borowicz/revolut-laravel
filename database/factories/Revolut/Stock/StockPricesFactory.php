<?php

namespace Database\Factories\Revolut\Stock;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Stock\StockPrices;
use Illuminate\Support\Str;

class StockPricesFactory extends AbstractRevolut
{
    protected $model = StockPrices::class;

    public function definition()
    {
        return [
            'hash' => Str::random(40), // Random 40-character hash
            'source' => $this->faker->word, // Random word for source
            'refreshed' => $this->faker->dateTimeThisYear, // Random date within this year
            'day' => $this->faker->date, // Random date
            'ticker' => $this->faker->word, // Random word for ticker
            'open' => $this->faker->randomFloat(2, 0, 1000), // Random open price between 0 and 1000
            'high' => $this->faker->randomFloat(2, 0, 1000), // Random high price between 0 and 1000
            'low' => $this->faker->randomFloat(2, 0, 1000), // Random low price between 0 and 1000
            'close' => $this->faker->randomFloat(2, 0, 1000), // Random close price between 0 and 1000
            'volume' => $this->faker->numberBetween(1000, 1000000), // Random volume between 1000 and 1000000
        ];
    }
}
