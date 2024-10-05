<?php

namespace App\Imports\Stock;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Imports\AbstractImport;
use App\Models\Revolut\Stock\StockTransaction;

class TransactionsImport extends AbstractImport
{
    public $importStats = [];

    public function model(array $row)
    {
        if ($row[0] == 'Date') {
            return null;
        }

        $importStats = Session::get('importStats');
        $importStats['total']++;

        $hash = AbstractRevolutController::setHash($row);
        $check = StockTransaction::where('hash', $hash)->first();
        if ($check) {
            $importStats['skipped']++;
            Session::put('importStats', $importStats);

            return null;
        }

        $ticker = $row[1] ?? '';
        $type = $row[2] ?? '';
        $quantity = $row[3] ?? 0;
        $price = $row[4] ?? 0;
        $total = $row[5] ?? 0;
        $currency = $row[6] ?? '';
        $rate = $row[7] ?? '';

        $quantity = $this->setNumber($quantity);
        $price = $this->setNumber($price);
        $total = $this->setNumber($total);
        $rate = $this->setNumber($rate);

        $entry = [
            'hash'            => $hash,
            'date'            => $row[0],
            'ticker'          => $ticker,
            'type'            => $type,
            'quantity'        => $quantity,
            'price_per_share' => $price,
            'total_amount'    => $total,
            'currency'        => $currency,
            'fx_rate'         => $rate,
        ];

        $importStats['inserted']++;

        Session::put('importStats', $importStats);

        $results = StockTransaction::create($entry);

        debugbar()->info('$entry: ' . json_encode($entry, JSON_PRETTY_PRINT));
//        return new StockTransaction($entry);
        return $results;
    }
}
