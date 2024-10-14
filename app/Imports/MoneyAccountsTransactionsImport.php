<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Money\CashTransaction;

class MoneyAccountsTransactionsImport extends AbstractImport
{
    public $importStats = [];

    public function model(array $row)
    {
        if ($row[0] === 'Type') {
            return null;
        }

        $importStats = Session::get('importStats');
        $importStats['total']++;

        $hash = AbstractRevolutController::setHash($row);
        $when = Carbon::parse($row[3] ?? '')->format('Y-m-d');

        if (CashTransaction::where('hash', $hash)->exists()) {
            $importStats['skipped']++;
            Session::put('importStats', $importStats);
            return null;
        }

        $amount = str_replace(',', '.', $row[5]);
        $amount = number_format($amount, 2, '.', '');
        $fee = str_replace(',', '.', $row[6]);
        $fee = number_format($fee, 2, '.', '');

        // Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
        // CASHBACK,Savings,2019-12-20 12:42:05,2019-12-22 09:31:45,Metal Cashback,0.01,0.00,EUR,COMPLETED,0.01
        $item = [
            'hash' => $hash,
            'date' => $when,

            'type' => $row[0],
            'product' => $row[1] ?? '',
            'started_date' => $row[2] ?? '',
            'completed_date' => $row[3] ?? '',
            'description' => $row[4] ?? '',
            'amount' => $amount,
            'amount_raw' => $row[5],
            'fee' => $fee,
            'fee_raw' => $row[6],
            'currency' => $row[7],
            'state' => $row[8],
            'balance' => $row[9],
        ];

        $importStats['inserted']++;
        Session::put('importStats', $importStats);

        return new CashTransaction($item);
    }
}
