<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Commodities\CommoditiesTransaction;

class CommoditiesTransactionsImport extends AbstractImport
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
        $check = CommoditiesTransaction::where('hash', $hash)->first();
        if ($check) {
            $importStats['skipped']++;
            Session::put('importStats', $importStats);

            return null;
        }

//        Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
        $symbol = $row[0] ?? '';
        if (empty($symbol)) {
            return null;
        }

        $type = $row[1] ?? '';
        $product = $row[2] ?? '';
        $dateStarted = $row[3] ?? '';
        $dateCompleted = $row[4] ?? '';
        $description = $row[5] ?? '';
        $amount = $row[5] ?? 0;
        $fees = $row[5] ?? 0;
        $currency = $row[6] ?? '';
        $state = $row[6] ?? '';
        $balance = $row[6] ?? 0;

        $dateStarted = Carbon::parse($dateStarted)->format('Y-m-d H:i:s');
        $dateCompleted = Carbon::parse($dateCompleted)->format('Y-m-d H:i:s');

        $amount = $this->cleanValue($amount);
//        $price = $this->cleanValue($price);
        $balance = $this->cleanValue($balance);
        $fees = $this->cleanValue($fees);

        $entry = [
            'hash'           => $hash,
            'type'           => $type,
            'product'        => $product,
            'started_date'   => $dateStarted,
            'completed_date' => $dateCompleted,
            'description'    => $description,
            'amount'         => $amount,
            'fee'            => $fees,
            'currency'       => $currency,
            'state'          => $state,
            'balance'        => $balance,
        ];

        $importStats['inserted']++;

        Session::put('importStats', $importStats);

        $results = Commodities::create($entry);

        debugbar()->info('$entry: ' . json_encode($entry, JSON_PRETTY_PRINT));

        return $results;
    }
}
