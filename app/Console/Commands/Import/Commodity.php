<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\ImportDataInterface;
use App\Imports\CommoditiesTransactionsImport;

/**
 * @see /revolut/crypto/transactions
 *  records c.a.
 *- -***
 *
 * Class Commodity
 */
class Commodity extends AbstractImportCommand implements ImportDataInterface
{
    protected $signature = 'revolut:import:commodity {file}';

    protected $description = 'Import commodity transactions';

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
        $result = Excel::import(new CommoditiesTransactionsImport(), $this->csvFile);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:23');
    }
}

