<?php

namespace Database\Seeders\Revolut;

use Illuminate\Database\Seeder;
use App\Models\Revolut\Money\CashTransaction;

class CashTransactionSeeder extends Seeder
{
    protected $model = CashTransaction::class;

    public function run(): void
    {
        $this->model::factory()->count(50)->create();
    }
}
