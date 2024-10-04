<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Revolut\Stock\StockMarket;

/**
 * - -***
 * php artisan db:seed --class=StockMarketSeeder
 */
class StockMarketSeeder extends Seeder
{
    public function run()
    {
        $dataTimeNow = date('Y-m-d H:i:s');

        $entries = [
            [
                'name'       => 'Consolidated Issue Listed on NASDAQ Global Select ',
                'disabled'   => 0,
                'country'    => 'United States',
                'suffix_ft'  => 'NSQ',
                'suffix_gf'  => 'NASDAQ',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'New York Stock Exchange',
                'disabled'   => 0,
                'symbol'     => 'NYSE',
                'country'    => 'United States',
                'suffix_bb'  => 'US',
                'suffix_ft'  => 'NYQ',
                'suffix_gf'  => 'NYSE',
                'currency'   => 'USD',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'New York Consolidated',
                'disabled'   => 0,
                'country'    => 'United States',
                'suffix_ft'  => 'NYQ',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Tokyo Stock Exchange',
                'symbol'     => 'TSE',
                'country'    => 'Japan',
                'currency'   => 'JPY',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'London Stock Exchange',
                'symbol'     => 'LSE',
                'country'    => 'United Kingdom',
                'currency'   => 'GBP',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Berlin Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'BER',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Dusseldorf Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'DUS',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'XETRA',
                'country'    => 'Germany',
                'suffix_ft'  => 'GER',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'German Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'FRA',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Hamburg Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'HAM',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Hanover Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'HAN',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Munich Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'MUN',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Stuttgart Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'STU',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Santiago Stock Exchange',
                'country'    => 'Chile',
                'suffix_ft'  => 'SGO',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Berne Stock Exchange',
                'country'    => 'Switzerland',
                'suffix_ft'  => 'BRN',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'SIX Swiss Exchange',
                'country'    => 'Switzerland',
                'suffix_ft'  => 'SWX',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Wiener Borse',
                'country'    => 'Austria',
                'suffix_ft'  => 'VIE',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Ukrainian Stock Exchange',
                'country'    => 'Ukraine',
                'suffix_ft'  => 'UAX',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Mexico Stock Exchange',
                'country'    => 'Mexico',
                'suffix_ft'  => 'MEX',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'German Composite',
                'country'    => 'Germany',
                'suffix_ft'  => 'DEU',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'OTC Markets Group Inc - Limited Information',
                'country'    => 'United States',
                'suffix_ft'  => 'PKL',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Stock Exchange of Sao Paulo',
                'country'    => 'Brazil',
                'suffix_ft'  => 'SAO',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
            [
                'name'       => 'Borsa Italia MTA (Equities)',
                'country'    => 'Italy',
                'suffix_ft'  => 'MIL',
                'created_at' => $dataTimeNow,
                'updated_at' => $dataTimeNow,
            ],
        ];

        foreach ($entries as $entry) {
            $check = StockMarket::where('name', $entry['name'])->first();
            if ($check) {
                continue;
            }

            DB::table('stock_markets')->insert($entry);
        }
    }
}
