<?php

namespace App\Imports\Crypto;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Imports\AbstractImport;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Crypto\CryptoTransaction;

class CryptoTransactionsImport extends AbstractImport
{
    public $importStats = [];

    public function model(array $row)
    {
        if (stristr($row[0], 'symbol')) {
            return null;
        }

        $importStats = Session::get('importStats');
        $importStats['total']++;

        $hash = AbstractRevolutController::setHash($row);
        $check = CryptoTransaction::where('hash', $hash)->first();
        if ($check) {
            $importStats['skipped']++;
            Session::put('importStats', $importStats);
//            $check->update();

            return null;
        }

//        Symbol,Type,Quantity,Price,Value,Fees,Date
        $symbol = $row[0] ?? '';
        if (empty($symbol)) {
            return null;
        }

        $type = $row[1] ?? '';
        $quantity = $row[2] ?? 0;
        $price = $row[3] ?? 0;
        $value = $row[4] ?? 0;
        $fees = $row[5] ?? 0;
        $when = $row[6] ?? '';
        $when = Carbon::parse($when)->format('Y-m-d H:i:s');

        $currency = $this->getCurrency($price);
        $currency = htmlspecialchars_decode($currency);

        $price = $this->cleanValue($price);

        $quantity = $this->cleanValue($quantity);
        $value = $this->cleanValue($value);
        $fees = $this->cleanValue($fees);

        $entry = [
            'hash'     => $hash,
            'date'     => $when,
            'symbol'   => $symbol,
            'type'     => $type,
            'quantity' => $quantity,

            'currency' => $currency,

            'price'    => $price,
            'value'    => $value,
            'fees'     => $fees,
        ];

        $importStats['inserted']++;

        Session::put('importStats', $importStats);

        $results = CryptoTransaction::create($entry);

        debugbar()->info('$entry: ' . json_encode($entry, JSON_PRETTY_PRINT));

        return $results;
    }
}
