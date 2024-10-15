<?php

namespace Database\Factories\Revolut\Commodities;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Commodities\CommoditiesTicker;
use Illuminate\Support\Str;

/**
 * @extends AbstractRevolut<CommoditiesTicker>
 */
class CommoditiesTickerFactory extends AbstractRevolut
{
    protected $model = CommoditiesTicker::class;

    public function definition()
    {
        return [
            'disabled' => $this->faker->boolean,
            'hash' => Str::random(40),
            'ticker' => $this->faker->randomElement(self::getTickersCommodities()), // Losowy ticker z listy
            'url' => $this->faker->url,
            'notes' => $this->faker->sentence,
        ];
    }
}
