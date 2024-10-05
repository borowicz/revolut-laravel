<?php

namespace App\Imports\Stock;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Imports\AbstractImport;
use App\Models\Revolut\StockProfitLossTransaction;

class ProfitLossOtherImport extends AbstractImport
{
    public $importStats = [];

    public function model(array $row)
    {
        if (stristr($row[0], 'Date') || stristr($row[0], 'Income')
        ) {
            return null;
        }

        $this->setModel(StockProfitLossTransaction::class);

        $importStats = Session::get('importStats');
        $importStats['total']++;

        $hash = AbstractRevolutController::setHash($row);

        $check = $this->model::where('hash', $hash)->first();
        if ($check) {
            $importStats['skipped']++;
            Session::put('importStats', $importStats);

            return null;
        }

        $value = $row[1] ?? 0;
        if (0 == $value) {
            return;
        }

        $item = [
            'hash'           => $hash,
            'date_acquired'  => $row[0], //Date acquired
            'date_sold'      => $row[1], //Date sold
            'symbol'         => $row[2], //Symbol
            'security_name'  => $row[3], //Security name
            'isin'           => $row[4], //ISIN
            'country'        => $row[5], //Country
            'quantity'       => $row[6], //Quantity
            'cost_basis'     => $row[7], //Cost basis
            'gross_proceeds' => $row[8], //Gross proceeds
            'gross_pnl'      => $row[9], //Gross PnL
            'currency'       => $row[10], //Currencys
        ];

        dd($item);
        $importStats['inserted']++;

        Session::put('importStats', $importStats);

        return $this->model::create($item);
    }
}
