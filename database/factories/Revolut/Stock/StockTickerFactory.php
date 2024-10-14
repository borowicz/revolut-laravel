<?php

namespace Database\Factories\Revolut\Stock;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Stock\StockTicker;
use Illuminate\Support\Str;

class StockTickerFactory extends AbstractRevolut
{
    protected $model = StockTicker::class;

    public function definition()
    {
        return [
            'disabled' => $this->faker->boolean, // Randomly true or false
            'hash' => Str::random(40), // Random 40-character hash
            'stock_markets_id' => $this->faker->numberBetween(1, 100), // Random stock market ID between 1 and 100
            'ticker' => $this->faker->word, // Random word for ticker
            'url' => $this->faker->url, // Random URL
            'notes' => $this->faker->sentence, // Random sentence for notes
        ];
    }
}
