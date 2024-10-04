<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Console\ImportDataInterface;

/**
 * @see /revolut/stock/profit-loss-other/transactions
 *  records c.a.
 *- -***
 *
 * Class StockProfitLossOther
 */
class StockProfitLossOther extends AbstractImportCommand implements ImportDataInterface
{
    protected $signature = 'revolut:import:stock:other-profit-loss {file} {--force=0}';

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

