<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
                                         * ddev exec ./artisan db:seed --class=DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $userData = [
            [
                'name' => 'cli',
                'email' => 'cli@r.local',
                'password' => Hash::make(uniqid('cli', true)),
            ],
            [
                'name' => 'revolut',
                'email' => 'revolut@r.local',
                'password' => Hash::make('csv'),
            ]
        ];

        $userTable = (new User())->getTable();
        foreach ($userData as $user) {
            $userCheck = User::select()
                ->where('email', $user['email'])
                ->first();
            if (!$userCheck) {
//                User::factory()->create($user);
                DB::table($userTable)->insert($user);
            }
        }

        $this->call(NoteSeeder::class);
        $this->call(CurrenciesSeeder::class);
        $this->call(StockMarketSeeder::class);
        $this->call(TickersSeeder::class);

//        $this->call(CashCurrentFactorySeeder::class);
//        $this->call(CashTransactionSeeder::class);
//        $this->call(CommoditiesTickerSeeder::class);
//        $this->call(CommoditiesTransactionSeeder::class);
//        $this->call(CryptoTransactionSeeder::class);
//        $this->call(CurrencyExchangesSeeder::class);
//        $this->call(StockPricesSeeder::class);
//        $this->call(StockProfitLossOtherTransactionSeeder::class);
//        $this->call(StockProfitLossTransactionSeeder::class);
//        $this->call(StockRoboTransactionSeeder::class);
//        $this->call(StockTickerSeeder::class);
//        $this->call(StockTransactionSeeder::class);
    }
}
