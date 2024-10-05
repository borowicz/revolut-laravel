<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\ImportDataInterface;
use App\Imports\Stock\TransactionsImport;

//use Illuminate\Support\Facades\Schedule;

/**
 * @see /revolut/stock
 *  records c.a. 800
 *- -***
 *
 * Class StockTransactions
 */
class StockTransactions extends AbstractImportCommand implements ImportDataInterface
{
    protected $signature = 'revolut:import:stock:transactions {file}';

    protected $description = 'Import stock transaction from csv file';

    public function handle()
    {
        $this->init();
        $this->info(' >> CSV: ' . $this->csvFile, OutputInterface::VERBOSITY_VERBOSE);

        $this->getData();

        $this->getSummary();

        return Command::SUCCESS;
    }

    public function getData()
    {
        $result = Excel::import(new TransactionsImport(), $this->csvFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:23');
    }
}
