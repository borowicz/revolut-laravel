<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\FetchDataInterface;
use App\Imports\CommoditiesTransactionsImport;

/**
 * @see revolut/commodities/transactions
 *  records c.a.
 *- -***
 *
 * Class Commodity
 */
class Commodity extends AbstractImportCommand implements FetchDataInterface
{
    protected $signature = 'revolut:import:commodity {file}';

    protected $description = 'Import commodity transactions';

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
        $result = Excel::import(new CommoditiesTransactionsImport(), $this->sourceFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:35');
    }
}

