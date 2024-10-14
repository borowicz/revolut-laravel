<?php

namespace Database\Factories\Revolut\Stock;

use Database\Factories\Revolut\AbstractRevolut;
use App\Models\Revolut\Stock\CashCurrent;
use Illuminate\Support\Str;

class CashCurrentFactory extends AbstractRevolut
{
    protected $model = CashCurrent::class;

    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeThisDecade, // Random date within the last decade
            'total' => $this->faker->randomFloat(2, 0, 10000), // Random total between 0 and 10000
            'note' => $this->faker->sentence, // Random sentence for note
        ];
    }
}
