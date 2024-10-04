<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Session;
use App\Models\Revolut\StockTransaction;

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

        $hash = hash_hmac('sha1', serialize($row), config('app.key'));

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
            'hash'     => $hash,
            'date'     => $row[0],
            'ticker'   => $ticker,
            'type'     => $type,
            'quantity' => $quantity,
            'price'    => $price,
            'total'    => $total,
            'currency' => $currency,
            'rate'     => $rate,
        ];

        $importStats['inserted']++;

        Session::put('importStats', $importStats);

        $results = StockTransaction::create($entry);

        debugbar()->info('$entry: ' . json_encode($entry, JSON_PRETTY_PRINT));
//        return new StockTransaction($entry);
        return $results;
    }
}
