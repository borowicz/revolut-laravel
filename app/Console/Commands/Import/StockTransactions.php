<?php

namespace App\Console\Commands\Import;

use App\Console\FetchDataInterface;
use App\Imports\Stock\TransactionsImport;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Output\OutputInterface;

//use Illuminate\Support\Facades\Schedule;

/**
 * @see /revolut/stock
 *  records c.a. 800
 *- -***
 *
 * Class StockTransactions
 */
class StockTransactions extends AbstractImportCommand implements FetchDataInterface
{
    protected $signature = 'revolut:import:stock:transactions {file}';

    protected $description = 'Import stock transaction from csv file';

    public function handle()
    {
        $this->init();
        $this->info(' >> CSV: ' . $this->sourceFile, OutputInterface::VERBOSITY_VERBOSE);

        if (!$this->isValidCsv()) {
            $this->error(' >> Invalid CSV: ' . $this->sourceFile);

            return Command::FAILURE;
        }

        $this->getData();

        $this->getSummary();

        return Command::SUCCESS;
    }

    public function getData()
    {
        $result = Excel::import(new TransactionsImport(), $this->sourceFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:23');
    }
}
