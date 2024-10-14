<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\FetchDataInterface;
use App\Console\AbstractCsvImport;
use App\Imports\Stock\TransactionsImport;

/**
 * @see /revolut/stock
 *  records c.a. 800
 *- -***
 *
 * Class StockTransactions
 */
class StockTransactions extends AbstractCsvImport implements FetchDataInterface
{
    protected $signature = 'revolut:import:stock:transactions {file}';

    protected $description = 'Import stock transaction from csv file';

    public function getData()
    {
        $result = Excel::import(new TransactionsImport(), $this->sourceFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:11');
    }
}
