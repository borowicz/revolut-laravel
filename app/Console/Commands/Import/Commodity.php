<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\FetchDataInterface;
use App\Console\AbstractCsvImport;
use App\Imports\CommoditiesTransactionsImport;

/**
 * @see revolut/commodities/transactions
 *  records c.a.
 *- -***
 *
 * Class Commodity
 */
class Commodity extends AbstractCsvImport implements FetchDataInterface
{
    protected $signature = 'revolut:import:commodity {file}';

    protected $description = 'Import commodity transactions';

    public function getData()
    {
        $result = Excel::import(new CommoditiesTransactionsImport(), $this->sourceFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:35');
    }
}

