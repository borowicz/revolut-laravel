<?php

namespace App\Imports;

use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Crypto\CryptoTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

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
        $fee = $row[5] ?? 0;

        $when = $row[6] ?? '';
        if (!empty($when)) {
            $when = Carbon::parse($when)->format('Y-m-d H:i:s');
        }

        $quantity = str_replace(',', '', $quantity);
        $price = str_replace(',', '', $price);
        $value = str_replace(',', '', $value);
        $fee = str_replace(',', '', $fee);

        $currency = $this->getCurrency($price);
        $currency = htmlspecialchars_decode($currency);

        $price = $this->cleanValue($price);

//        $quantity = $this->cleanValue($quantity);
        $quantity = (float)$quantity;
        $value = $this->cleanValue($value);
        $fee = $this->cleanValue($fee);

        $entry = [
            'hash'     => $hash,
            'date'     => $when,
            'symbol'   => $symbol,
            'type'     => $type,

            'currency' => $currency,

            'quantity'     => $quantity,
            'quantity_raw' => $row[2] ?? 0,

            'price'     => $price,
            'price_raw' => $row[3] ?? 0,
            'value'     => $value,
            'value_raw' => $row[4] ?? 0,
            'fees'      => $fee,
            'fees_raw'  => $row[5] ?? 0,
        ];

        $importStats['inserted']++;

        try {
            CryptoTransaction::create($entry);
        } catch (\Exception $e) {
            $importStats['failed']++;
            Session::put('importStats', $importStats);
        }

        Session::put('importStats', $importStats);

        return null;
    }
}
