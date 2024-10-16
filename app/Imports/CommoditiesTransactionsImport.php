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
        if (stristr($row[0], 'type')) {
            return null;
        }

        $importStats = Session::get('importStats');
        $importStats['total']++;

        $hash = AbstractRevolutController::setHash($row);
        if (CommoditiesTransaction::where('hash', $hash)->exists()) {
            $importStats['skipped']++;
            Session::put('importStats', $importStats);

            return null;
        }

        if (empty($row[0])) {
            return null;
        }

        $dateStarted = $row[2] ?? '';
        if (!empty($dateStarted)) {
            $dateStarted = Carbon::parse($dateStarted)->format('Y-m-d H:i:s');
        }
        $dateCompleted = $row[3] ?? '';
        if (!empty($dateCompleted)) {
            $dateCompleted = Carbon::parse($dateCompleted)->format('Y-m-d H:i:s');
        }

        $amount = $row[5] ?? 0;
        $amount = str_replace(',', '.', $amount);
        $amount = number_format($amount, 2, '.', '');

        $fee = $row[6] ?? 0;
        $fee = str_replace(',', '.', $fee);
        $fee = number_format($fee, 2, '.', '');

        $balance = $row[9] ?? 0;
        $balance = str_replace(',', '.', $balance);
        $balance = number_format($balance, 2, '.', '');

        //Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
        $entry = [
            'hash'           => $hash,
            'type'           => $row[0] ?? '',
            'product'        => $row[1] ?? '',
            'started_date'   => $dateStarted,
            'completed_date' => $dateCompleted,
            'description'    => $row[4] ?? '',
            'amount'         => $amount,
            'amount_raw'     => $row[5] ?? 0,
            'fee'            => $fee,
            'fee_raw'        => $row[6] ?? 0,
            'currency'       => $row[7] ?? '',
            'state'          => $row[8] ?? '',
            'balance'        => $balance,
            'balance_raw'    => $row[9] ?? 0,
        ];

        try {
            CommoditiesTransaction::create($entry);
        } catch (\Exception $e) {
            $importStats['failed']++;
            Session::put('importStats', $importStats);
        }

        Session::put('importStats', $importStats);

        return null;
    }
}
