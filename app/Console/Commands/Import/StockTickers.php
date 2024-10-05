<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\ImportDataInterface;

/**
 * @see /revolut/stock/tickers
 *  records c.a.
 *- -***
 *
 * Class StockTickers
 */
class StockTickers extends AbstractImportCommand implements ImportDataInterface
{
    protected $signature = 'revolut:import:stock:tickers {file}';

    protected $description = 'Fetch and store stock profit loss from csv file';

    public function handle()
    {
        return Command::SUCCESS;
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        // TODO: Implement setCommandSchedule() method.
    }
}
