<?php

namespace App\Console\Commands\Fetch;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Stock\StockPrices;
use App\Models\Revolut\Stock\StockTransaction;
use App\Http\Services\{
    AlphaVantageService,
    PolygonIoService,
};


/**
 * ./artisan revolut:fetch:stock AAPL polygonIo --f=1 -vvv
 *
 *- -***
 */
class StockLastAtClose  extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:stock {ticker?} {service?} {--f|force=0}';

    protected $description = 'Fetch and store stock price by ticker';

    protected $tickers = [];

    protected $apiService;

    protected $apiSource;

    protected $apiSourceDefault = 'polygonIo';

    protected $disabledTickers = [];

    protected $tickersList = [];

    public $importStats = [
        'source'   => '',
        'total'    => 0,
        'inserted' => 0,
        'skipped'  => 0,
        'cached'   => 0,
    ];

    public function handle()
    {
        $selectedApi = $this->argument('service') ?? $this->apiSourceDefault;
        $this->apiService = $this->setApiService($selectedApi);
        $this->apiService->apiName = $selectedApi;
        $this->init();
        $this->importStats['source'] = get_class($this->apiService);

        $this->getData();

        $this->getSummary(false);

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
        $this->disabledTickers = StockPrices::getTickersDisabled();
        $this->tickersList = StockTransaction::getTickers();

        $ticker = $this->argument('ticker') ?? '';
        if (empty($ticker) || $ticker === 'all') {
            foreach ($this->tickersList as $tickerName) {
                $this->getStockPriceDataForTicker($tickerName);
            }
        } else {
            $this->getStockPriceDataForTicker($ticker);
        }

        return true;
    }

    public function formatDate(string $when): string
    {
        return date('Y-m-d', strtotime($when)) . ' 22:00:00';
    }

    public function setTicker(string $ticker, string $hash, string $when, string $refreshed, array $item): void
    {
        $item = array_values($item);

        $values = [
            'hash'      => $hash,
            'source'    => $this->apiService->apiName,
            'refreshed' => $refreshed,
            'day'       => $when,
            'ticker'    => $ticker,
            'open'      => $item[0],
            'high'      => $item[1],
            'low'       => $item[2],
            'close'     => $item[3],
            'volume'    => $item[4],
        ];

        StockPrices::create($values);
    }

    public function setStockPriceForTicker(string $ticker, array $apiData): int
    {
        foreach ($apiData['items'] as $when => $item) {
            $this->importStats['total']++;
            $hash = AbstractRevolutController::setHash($item);
            $when = $this->formatDate($when);

            $check = StockPrices::where('hash', $hash)->first();
            if ($check) {
                $this->importStats['skipped']++;
                continue;
            }

            $this->setTicker($ticker, $hash, $when, $apiData['refreshed'], $item);
            $this->importStats['inserted']++;
        }

        return 0;
    }

    public function getStockPriceDataForTickerData(string $ticker): int
    {
        $transactionsDate = AbstractRevolutController::getLastWorkDay();

        if (in_array($ticker, $this->disabledTickers)) {
            $msg = $ticker . ' - ' . $transactionsDate . ' - disabled ';
            $this->info($msg, OutputInterface::VERBOSITY_VERBOSE);
            Log::info($msg);

            return 1;
        }

        if ($this->force) {
            $check = false;
        } else {
            $check = StockPrices::checkDailyPrice($ticker, $transactionsDate);
        }

        if ($check) {
            $msg = $ticker . ' - ' . $transactionsDate . ' = ' . $check->day . ' - already fetched for ' . $ticker;
            Log::info($msg);

            return 1;
        }

        $apiData = $this->apiService->getStockPriceData($ticker, $transactionsDate, $this->force);

        if (!$apiData) {
            Log::error($ticker . ' - NO data ');

            return 2;
        }

        $this->setStockPriceForTicker($ticker, $apiData);

        return 0;
    }

    public function getStockPriceDataForTicker(string $ticker, bool $force = false): void
    {
        $this->info('ticker: ' . $ticker, OutputInterface::VERBOSITY_VERBOSE);

        $result = $this->getStockPriceDataForTickerData($ticker, $force);
        $message = AbstractRevolutController::getFetchResult($ticker, $result);
        if ($result > 1) {
            $this->error($message, OutputInterface::VERBOSITY_VERBOSE);
        } else {
            $this->info($message, OutputInterface::VERBOSITY_VERBOSE);
        }
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('7:01');
    }
}
