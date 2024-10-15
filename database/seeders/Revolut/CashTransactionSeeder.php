<?php

namespace Database\Seeders\Revolut;

use Illuminate\Database\Seeder;
use App\Models\Revolut\Money\CashTransaction;

class CryptoTransactionSeeder extends Seeder
{
    protected $model = CashTransaction::class;

    public function run(): void
    {
        CashTransaction::factory()->count(50)->create();
    }
}
