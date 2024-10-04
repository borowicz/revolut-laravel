<?php

namespace App\Console\Commands\Fetch;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Imports\CurrencyImport;
use App\Models\Revolut\Currency;
use App\Http\Services\AlphaVantageService;
use App\Http\Services\PolygonIoService;
use App\Models\Revolut\Stock\StockPrices;
use App\Http\Controllers\Revolut\AbstractRevolut;
use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;

class FetchStockLastAtClose  extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:stock {ticker?} {service?} {--f|force=0}';

    protected $description = 'Fetch and store stock price by ticker';

    protected $apiService;
    protected $apiSource = 'polygonIo';
    protected $disabledTickers = [];

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
