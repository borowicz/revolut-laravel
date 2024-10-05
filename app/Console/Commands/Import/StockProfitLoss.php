<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\ImportDataInterface;

/**
 * @see /revolut/stock/profit-loss/transactions
 *  records c.a.
 *- -***
 *
 * Class StockProfitLoss
 */
class StockProfitLoss extends AbstractImportCommand implements ImportDataInterface
{
    protected $signature = 'revolut:import:stock:profit-loss {file}';

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

