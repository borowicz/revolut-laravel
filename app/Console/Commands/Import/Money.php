<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\FetchDataInterface;
use App\Console\AbstractCsvImport;
use App\Imports\MoneyAccountsTransactionsImport;

/**
 * @see /revolut/money/transactions
 *  records c.a.
 *- -***
 *
 * ./artisan revolut:import:crypto storage/app/revolut/cash–accounts-statement.csv
 *
 * Class StockProfitLossOther
 */
class Money extends AbstractCsvImport implements FetchDataInterface
{
    protected $signature = 'revolut:import:money {file}';

    protected $description = 'Import money/cash accounts transactions';

    public function getData()
    {
        $result = Excel::import(new MoneyAccountsTransactionsImport(), $this->sourceFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:57');
    }
}

