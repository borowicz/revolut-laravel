<?php

namespace App\Imports;

use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\CurrencyExchanges;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CurrencyImport extends AbstractImport
{
    public $importStats = [];

    public function model(array $row)
    {
        if ($row[0] == 'Date') {
            return null;
        }

        $importStats = Session::get('importStats');
        $currentCurrency = $importStats['current'];
        $importStats['total']++;
        $importStats['sheets'][$currentCurrency]['total']++;

        $today = Carbon::today()->format('Y-m-d');
        $hash = AbstractRevolutController::setHash($row);
        $when = $row[0] ?? '';
        $when = Carbon::parse($when)->format('Y-m-d');

        $currency = Str::substr($currentCurrency, 0, 3);

        $check = CurrencyExchanges::where('hash', $hash)->first();
        if ($check) {
            $importStats['skipped']++;
            $importStats['sheets'][$currentCurrency]['skipped']++;
            Session::put('importStats', $importStats);

            return null;
        }

        $value = $row[1] ?? 0;
        if ($value <= 0) {
            return;
        }

        if ($when === $today) {
            return;
        }

        if (str_contains($value, ',')) {
            $value = str_replace(',', '.', $value);
        }

        $item = [
            'source'        => $importStats['source'],
            'hash'          => $hash,
            'date'          => $when,
            'currency'      => $currency,
            'code'          => $currentCurrency,
            'exchange_rate' => $this->setNumber($value, 6),
        ];

        $importStats['inserted']++;
        $importStats['sheets'][$currentCurrency]['inserted']++;

        Session::put('importStats', $importStats);

        return new CurrencyExchanges($item);
    }
}
