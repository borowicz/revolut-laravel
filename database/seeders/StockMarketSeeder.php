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
        $entries = $this->getArray();

        foreach ($entries as $entry) {
            $check = StockMarket::where('name', $entry['name'])->first();
            if ($check) {
                continue;
            }

            DB::table('stock_markets')->insert($entry);
        }
    }

    private function getArray()
    {
        return [
            [
                'name'       => 'Consolidated Issue Listed on NASDAQ Global Select',
                'disabled'   => 0,
                'country'    => 'United States',
                'symbol'     => 'NASDAQ',
                'suffix'     => 'NSQ', // official
                'suffix_ft'  => 'NSQ', // finantial times
                'suffix_bb'  => 'NSQ', // blomberg
                'suffix_gf'  => 'NASDAQ', // google finance
                'currency'   => 'USD',
            ],
            [
                'name'       => 'New York Stock Exchange',
                'disabled'   => 0,
                'symbol'     => 'NYSE',
                'country'    => 'United States',
                'suffix'     => 'NYQ',
                'suffix_ft'  => 'NYQ',
                'suffix_bb'  => 'US',
                'suffix_gf'  => 'NYSE',
                'currency'   => 'USD',
            ],
            [
                'name'       => 'New York Consolidated',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'NYC',
                'suffix'     => 'NYC',
                'suffix_ft'  => 'NYC',
                'suffix_bb'  => 'NYC',
                'suffix_gf'  => 'NYC',
                'country'    => 'United States',
                'currency'   => 'USD',
            ],
            [
                'name'       => 'Tokyo Stock Exchange',
                'symbol'     => 'TSE',
                'country'    => 'Japan',
                'currency'   => 'JPY',
                'short_name' => '',
                'disabled'   => 1,
                'suffix'     => 'TSE',
                'suffix_ft'  => 'TSE',
                'suffix_bb'  => 'TSE',
                'suffix_gf'  => 'TSE',
            ],
            [
                'name'       => 'London Stock Exchange',
                'symbol'     => 'LSE',
                'country'    => 'United Kingdom',
                'currency'   => 'GBP',
                'short_name' => '',
                'disabled'   => 1,
                'suffix'     => 'LSE',
                'suffix_ft'  => 'LSE',
                'suffix_bb'  => 'LSE',
                'suffix_gf'  => 'LSE',
            ],
            [
                'name'       => 'Berlin Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'BER',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'BER',
                'suffix'     => 'BER',
                'suffix_bb'  => 'BER',
                'suffix_gf'  => 'BER',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Dusseldorf Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'DUS',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'DUS',
                'suffix'     => 'DUS',
                'suffix_bb'  => 'DUS',
                'suffix_gf'  => 'DUS',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'XETRA',
                'country'    => 'Germany',
                'suffix_ft'  => 'GER',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'XET',
                'suffix'     => 'XET',
                'suffix_bb'  => 'XET',
                'suffix_gf'  => 'XET',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'German Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'FRA',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'FRA',
                'suffix'     => 'FRA',
                'suffix_bb'  => 'FRA',
                'suffix_gf'  => 'FRA',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Hamburg Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'HAM',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'HAM',
                'suffix'     => 'HAM',
                'suffix_bb'  => 'HAM',
                'suffix_gf'  => 'HAM',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Hanover Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'HAN',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'HAN',
                'suffix'     => 'HAN',
                'suffix_bb'  => 'HAN',
                'suffix_gf'  => 'HAN',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Munich Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'MUN',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'MUN',
                'suffix'     => 'MUN',
                'suffix_bb'  => 'MUN',
                'suffix_gf'  => 'MUN',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Stuttgart Stock Exchange',
                'country'    => 'Germany',
                'suffix_ft'  => 'STU',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'STU',
                'suffix'     => 'STU',
                'suffix_bb'  => 'STU',
                'suffix_gf'  => 'STU',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Santiago Stock Exchange',
                'country'    => 'Chile',
                'suffix_ft'  => 'SGO',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'SGO',
                'suffix'     => 'SGO',
                'suffix_bb'  => 'SGO',
                'suffix_gf'  => 'SGO',
                'currency'   => 'CLP',
            ],
            [
                'name'       => 'Berne Stock Exchange',
                'country'    => 'Switzerland',
                'suffix_ft'  => 'BRN',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'BRN',
                'suffix'     => 'BRN',
                'suffix_bb'  => 'BRN',
                'suffix_gf'  => 'BRN',
                'currency'   => 'CHF',
            ],
            [
                'name'       => 'SIX Swiss Exchange',
                'country'    => 'Switzerland',
                'suffix_ft'  => 'SWX',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'SWX',
                'suffix'     => 'SWX',
                'suffix_bb'  => 'SWX',
                'suffix_gf'  => 'SWX',
                'currency'   => 'CHF',
            ],
            [
                'name'       => 'Wiener Borse',
                'country'    => 'Austria',
                'suffix_ft'  => 'VIE',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'VIE',
                'suffix'     => 'VIE',
                'suffix_bb'  => 'VIE',
                'suffix_gf'  => 'VIE',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'Ukrainian Stock Exchange',
                'country'    => 'Ukraine',
                'suffix_ft'  => 'UAX',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'UAX',
                'suffix'     => 'UAX',
                'suffix_bb'  => 'UAX',
                'suffix_gf'  => 'UAX',
                'currency'   => 'UAH',
            ],
            [
                'name'       => 'Mexico Stock Exchange',
                'country'    => 'Mexico',
                'suffix_ft'  => 'MEX',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'MEX',
                'suffix'     => 'MEX',
                'suffix_bb'  => 'MEX',
                'suffix_gf'  => 'MEX',
                'currency'   => 'MXN',
            ],
            [
                'name'       => 'German Composite',
                'country'    => 'Germany',
                'suffix_ft'  => 'DEU',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'DEU',
                'suffix'     => 'DEU',
                'suffix_bb'  => 'DEU',
                'suffix_gf'  => 'DEU',
                'currency'   => 'EUR',
            ],
            [
                'name'       => 'OTC Markets Group Inc - Limited Information',
                'country'    => 'United States',
                'suffix_ft'  => 'PKL',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'PKL',
                'suffix'     => 'PKL',
                'suffix_bb'  => 'PKL',
                'suffix_gf'  => 'PKL',
                'currency'   => 'USD',
            ],
            [
                'name'       => 'Stock Exchange of Sao Paulo',
                'country'    => 'Brazil',
                'suffix_ft'  => 'SAO',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'SAO',
                'suffix'     => 'SAO',
                'suffix_bb'  => 'SAO',
                'suffix_gf'  => 'SAO',
                'currency'   => 'BRL',
            ],
            [
                'name'       => 'Borsa Italia MTA (Equities)',
                'country'    => 'Italy',
                'suffix_ft'  => 'MIL',
                'short_name' => '',
                'disabled'   => 1,
                'symbol'     => 'MIL',
                'suffix'     => 'MIL',
                'suffix_bb'  => 'MIL',
                'suffix_gf'  => 'MIL',
                'currency'   => 'EUR',
            ],
        ];
    }
}
