<?php

namespace App\Imports\Stock;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Imports\AbstractImport;
use App\Models\Revolut\Stock\StockCost;

class CostsImport extends AbstractImport
{
    public $importStats = [];

    public function model(array $row)
    {
        if (stristr($row[0], 'Date') || stristr($row[0], 'Income')
        ) {
            return null;
        }

        $this->setModel(StockCost::class);

//        $importStats = Session::get('importStats');
//        $importStats['total']++;
//
//        $hash = AbstractRevolutController::setHash($row);
//
//        $check = $this->model::where('hash', $hash)->first();
//        if ($check) {
//            $importStats['skipped']++;
//            Session::put('importStats', $importStats);
//
//            return null;
//        }
//
//        $value = $row[1] ?? 0;
//        if (0 == $value) {
//            return;
//        }
//
//        $item = [
//            'hash'           => $hash,
//            'date_acquired'  => $row[0], //Date acquired
//        ];
//
//        $importStats['inserted']++;
//
//        Session::put('importStats', $importStats);
//
//        return $this->model::create($item);
    }
}
