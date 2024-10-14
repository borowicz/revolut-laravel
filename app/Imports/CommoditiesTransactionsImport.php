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

        //Type,Product,Started Date,Completed Date,Description,Amount,Fee,Currency,State,Balance
        $entry = [
            'hash'           => $hash,
            'type'           => $row[0] ?? '',
            'product'        => $row[1] ?? '',
            'started_date'   => $dateStarted,
            'completed_date' => $dateCompleted,
            'description'    => $row[4] ?? '',
            'amount'         => $this->cleanValue($row[5] ?? 0),
            'fee'            => $this->cleanValue($row[6] ?? 0),
            'currency'       => $row[7] ?? '',
            'state'          => $row[8] ?? '',
            'balance'        => $this->cleanValue($row[9] ?? 0),
        ];

        $importStats['inserted']++;
        Session::put('importStats', $importStats);

        $results = CommoditiesTransaction::create($entry);

        debugbar()->info('$entry: ' . json_encode($entry, JSON_PRETTY_PRINT));

        return $results;
    }
}
