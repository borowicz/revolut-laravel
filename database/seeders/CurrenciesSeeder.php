<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Revolut\CurrencyExchanges;

/**
 * - -***
 * php artisan db:seed --class=CurrenciesSeeder
 */
class CurrenciesSeeder extends Seeder
{
    public function run()
    {
        $model = new CurrencyExchanges();
        $tableName = $model->getTable();
        $dataTimeNow = date('Y-m-d H:i:s');

        $entries = [
            [
                'currency_code' => 'EUR',
                'name' => 'Euro',
                'symbol' => htmlspecialchars_decode('&euro;'),
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'currency_code' => 'USD',
                'name' => 'Dollar',
                'symbol' => htmlspecialchars_decode('&dollar;'),
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'currency_code' => 'GBP',
                'name' => 'British Pound',
                'symbol' => htmlspecialchars_decode('&#163;'),
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
        ];

        foreach ($entries as $entry) {
            $check = $model::where('currency_code', $entry['currency_code'])->first();
            if ($check) {
                continue;
            }

            DB::table($tableName)->insert($entry);
        }
    }
}
