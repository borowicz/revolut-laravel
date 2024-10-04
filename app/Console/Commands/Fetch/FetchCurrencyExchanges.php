<?php

namespace App\Console\Commands\Fetch;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Imports\CurrencyImport;
use App\Models\Revolut\Currency;
use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;


class FetchCurrencyExchanges extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:currency';

    protected $description = 'Fetch and store currency exchange from google sheet';

    protected $googleSheetUrl;

    protected $sheets = [
            'USDEUR',
            'EURUSD',
            'PLNEUR',
            'EURPLN',
            'PLNUSD',
            'USDPLN',
        ];

    public function handle()
    {
        return Command::SUCCESS;
    }

    public function getData()
    {
        // TODO: Implement getData() method.
    }

    public function fetchData(string $value)
    {
        // TODO: Implement fetchData() method.
    }

    public function setModel(): void
    {
        // TODO: Implement setModel() method.
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        // TODO: Implement setCommandSchedule() method.
    }
}
