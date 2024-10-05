<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Session;
use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;
use App\Http\Services\{
    AlphaVantageService,
    PolygonIoService,
};

/**
 *- -***
 */
class FetchStockLastAtClose  extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:stock {ticker?} {service?} {--f|force=0}';

    protected $description = 'Fetch and store stock price by ticker';

    protected $tickers = [];
    protected $apiService;
    protected $apiSource;
    protected $disabledTickers = [];

    public function handle()
    {
//dd(__CLASS__);
        $this->init();
        $selectedApi = $this->argument('service') ?? '';
        $this->apiService = $this->setApiService($selectedApi);

        $importStats = [
            'source'   => get_class($this->apiService),
            'total'    => 0,
            'inserted' => 0,
            'skipped'  => 0,
        ];
        Session::put('importStats', $importStats);
//dd($this->apiService);
        $this->getData();
//
        $this->getSummary();

        return Command::SUCCESS;
    }

    public function setApiService(string $selectedService = 'polygonIo')
    {
        $selectedService = strtolower($selectedService);

        return match (strtolower($selectedService)) {
            'alphavantage', 'alpha', 'a' => new AlphaVantageService(),
            'polygonio', 'polygon', 'p', '' => new PolygonIoService(),
            default => new PolygonIoService(),
        };
    }

    public function getData(): bool
    {
        return true;
    }

    public function fetchData(string $value)
    {

    }

    public function getTickers() : array
    {
        return StockTransaction::getTickers();
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('7:01');
    }
}
