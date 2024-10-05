<?php

namespace App\Console\Commands\Import\Stock;

use App\Console\Commands\Import\AbstractImportCommand;
use App\Console\ImportDataInterface;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

/**
 * @see /revolut/stock/profit-loss-other/transactions
 *  records c.a.
 *- -***
 *
 * Class StockProfitLossOther
 */
class StockProfitLossOther extends AbstractImportCommand implements ImportDataInterface
{
    protected $signature = 'revolut:import:stock:other-profit-loss {file}';

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

