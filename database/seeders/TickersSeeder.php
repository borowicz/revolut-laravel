<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Revolut\Stock\StockTicker;

/**
 * - -***
 * php artisan db:seed --class=TickersSeeder
 */
class TickersSeeder extends Seeder
{
    public function run(): void
    {
        $entries = $this->getArray();

        foreach ($entries as $entry) {
            $check = StockTicker::where('ticker', $entry['ticker'])->first();
            if ($check) {
                continue;
            }

            $entry['stock_markets_id'] !== null ? (int)$entry['stock_markets_id'] : null;

            DB::table('stock_tickers')->insert($entry);
        }
    }

    private function getArray()
    {
        return [
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'ed2d04efb1445bd606fd81400df591620c16e37c',
                'ticker'           => 'AAPL',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '1eb3e7ebfcf2815881d0c517ef94b116139da468',
                'ticker'           => 'AMD',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'b2372a0cb0a1a31af4447ab84d879f1c12605e8d',
                'ticker'           => 'AMZN',
            ],
            [
                'stock_markets_id' => 2,
                'disabled'         => 0,
                'hash'             => 'f3863a42df3e6c3a4e295950fbb61b360877e466',
                'ticker'           => 'BAM',
            ],
            [
                'stock_markets_id' => 3,
                'disabled'         => 1,
                'hash'             => 'd5b264cca4c071091a6b1a8cbdc5b54906d55c07',
                'ticker'           => 'BBBYQ',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '069de8ae6f51a368a6b6c5428252fd6902b57a5c',
                'ticker'           => 'CLNE',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'f4f38bad2f2b3c461413e0a1b673422cc88069a9',
                'ticker'           => 'CMA',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'c449ef345112872c871a82a895e8b76338030d61',
                'ticker'           => 'COIN',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'f7aa4dd532cd93ca76c7b43ad3da73d6a458e551',
                'ticker'           => 'DB',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '3668e1c99b5e0d8480aa5a149fc296350fe980f3',
                'ticker'           => 'DE',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '391f36903f579e1a20eef42f09ac5e2dc7bd2fbd',
                'ticker'           => 'DIS',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'eef5c295ff54be8f514d84ba49c54c18af69f463',
                'ticker'           => 'DJT',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'a7a3ec8bc8734a3dbc32e76ae82b8c322906bbb3',
                'ticker'           => 'ENVX',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '9783d30e51b6cc224818420d2d15c027f63c5b7b',
                'ticker'           => 'EXLS',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '41a0f343d99552ec20421ce3dc024bd6520d7634',
                'ticker'           => 'F',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '3659781c5ed980392904d1cc5e1e84c529aed42c',
                'ticker'           => 'FREY',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '59141a9814b07eb36f00d09f59372de6adae7239',
                'ticker'           => 'FTNT',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '27f35d6bc4810f8866153e39764e89806479d84c',
                'ticker'           => 'GFI',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'f9bbe589923ec9c436ebc196cd5ab608a892dabd',
                'ticker'           => 'GM',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'f6de0da6a5e554c04822030eb08795c200cda09d',
                'ticker'           => 'GME',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '83e3238da5a0ac96dd42446cd76ff5039e02b1e6',
                'ticker'           => 'GOOGL',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'fa8fcaef15c9c9a6512f05d38c8288902940ca8c',
                'ticker'           => 'GTLB',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'ec9252763f62bce4e211c29f56f6ae2f64236a33',
                'ticker'           => 'HOOD',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '9f985802a1f2cf0b28757f2b16d9ff2c2dec929c',
                'ticker'           => 'INTC',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '676a0570c2dbe574c10d56d4c0c84ee6ce6d5159',
                'ticker'           => 'MAXN',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'c0ade30afe0b1ede27dc6aab163c92ad821c0443',
                'ticker'           => 'META',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'ccdbf6e1bd134002bcf1ac92183e992d3f7fd439',
                'ticker'           => 'MNTS',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'af0a0f96184bc9cb25d453b7c6562799652dd1c7',
                'ticker'           => 'NET',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'ee6e98ecfdc9a4ef10e65137cc904b4242760ff9',
                'ticker'           => 'NVAX',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '2974aa771b35649958ab65101f29f471eec71faa',
                'ticker'           => 'NVDA',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '8c2ae5cee0f98299e34f7ced964b3d07ecae9196',
                'ticker'           => 'PBF',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '47dad5439547e686adc4fcf73f5525f6e1775ac0',
                'ticker'           => 'PLTR',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'bc5cb6cc7c8ff49e2adb152133a6052c0e253983',
                'ticker'           => 'PYPL',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'cd8b1643454badbda2a43db83983a63e3c5166e1',
                'ticker'           => 'RIOT',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '065f21e27c6131371c01b563341e0d6b15163c8f',
                'ticker'           => 'RKLB',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'b88321b93efb6796df9d509735fbbe2f2cf9535d',
                'ticker'           => 'STEM',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'fec0adcd36477d65778470d0062a8aae7ce469c4',
                'ticker'           => 'TLRY',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '79d198df162823e1cbc92c09e117786508e8915b',
                'ticker'           => 'TSLA',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '782b57188d1fc4ecab215c05d2d2baa67595a56f',
                'ticker'           => 'TSM',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => 'ba1f360db40b0427725572cc02dd80a7fdef6e32',
                'ticker'           => 'TWTR',
            ],
            [
                'stock_markets_id' => 1,
                'disabled'         => 0,
                'hash'             => '0051acc99c9faa513c342a0f07e1c7981f8de354',
                'ticker'           => 'WMT',
            ]
        ];
    }
}
