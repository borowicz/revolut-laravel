<?php

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Console\ImportDataInterface;

/**
 * @see /revolut/crypto/transactions
 *  records c.a.
 *- -***
 *
 * Class StockProfitLossOther
 */
class Crypto extends AbstractImportCommand implements FetchDataInterface
{
    protected $signature = 'revolut:import:crypto {file} {--force=0}';

    protected $description = 'Import crypto transactions';

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

