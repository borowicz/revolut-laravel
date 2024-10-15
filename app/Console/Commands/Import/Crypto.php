<?php

namespace App\Console\Commands\Import;

use App\Console\AbstractCsvImport;
use App\Console\FetchDataInterface;
use App\Imports\CryptoTransactionsImport;
use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @see /revolut/crypto/transactions
 *  records c.a.
 *- -***
 *
 * ./artisan revolut:import:crypto storage/app/revolut/crypto–account-statement.csv
 *
 * Class StockProfitLossOther
 */
class Crypto extends AbstractCsvImport implements FetchDataInterface
{
    protected $signature = 'revolut:import:crypto {file}';
    protected $description = 'Import crypto transactions';
    public $sourceFile;

    public function getData()
    {
        $result = Excel::import(new CryptoTransactionsImport(), $this->sourceFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:47');
    }
}
