<?php

namespace Database\Seeders\Revolut;

use Illuminate\Database\Seeder;
use App\Models\Revolut\Stock\CashCurrent;

class CashCurrentSeeder extends Seeder
{
    protected $model = CashCurrent::class;

    public function run(): void
    {
        CashCurrent::factory()->count(50)->create();
    }
}
