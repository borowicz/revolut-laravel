<?php

namespace Tests\Console\Commands\Fetch;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Fetch\StockLastAtClose;
use App\Models\Revolut\Stock\StockPrices;
use App\Models\Revolut\Stock\StockTransaction;
use App\Http\Services\AlphaVantageService;
use App\Http\Services\PolygonIoService;
use Illuminate\Support\Facades\Log;

it('has the correct command signature', function () {
    $command = new StockLastAtClose();
    expect($command->getName())->toBe('revolut:fetch:stock');
});

it('has the correct description', function () {
    $command = new StockLastAtClose();
    expect($command->getDescription())->toBe('Fetch and store stock price by ticker');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new StockLastAtClose();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('1 7 * * *');
    expect($events[0]->command)->toBe(StockLastAtClose::class);
});

it('fetches data for all tickers when no ticker is specified', function () {
    $command->shouldReceive('getStockPriceDataForTicker')->twice();
    $result = $command->getData();
    expect($result)->toBeTrue();
});

it('fetches data for a specific ticker', function () {
    StockPrices::shouldReceive('getTickersDisabled')->andReturn([]);
    StockTransaction::shouldReceive('getTickers')->andReturn(['AAPL', 'GOOGL']);
    $command = new StockLastAtClose();
    StockPrices::shouldReceive('getTickersDisabled')->andReturn([]);
    StockTransaction::shouldReceive('getTickers')->andReturn(['AAPL']);
    $command = new StockLastAtClose();
    $command->shouldReceive('getStockPriceDataForTicker')->once();
    $command->setArgument('ticker', 'AAPL');
    $result = $command->getData();
    expect($result)->toBeTrue();
});

it('skips disabled tickers', function () {
    StockPrices::shouldReceive('getTickersDisabled')->andReturn(['AAPL']);
    StockTransaction::shouldReceive('getTickers')->andReturn(['AAPL']);
    Log::shouldReceive('info')->once();
    $command = new StockLastAtClose();
    $result = $command->getStockPriceDataForTickerData('AAPL');
    expect($result)->toBe(1);
});

it('inserts new stock price data', function () {
    StockPrices::shouldReceive('checkDailyPrice')->andReturn(false);
    StockPrices::shouldReceive('create')->once();
    $command = new StockLastAtClose();
    $apiData = [
        'items' => [
            '2023-10-01' => [100, 110, 90, 105, 1000]
        ],
        'refreshed' => '2023-10-01'
    ];
    $result = $command->setStockPriceForTicker('AAPL', $apiData);
    expect($result)->toBe(0);
    expect($command->importStats['inserted'])->toBe(1);
});

it('skips already fetched stock price data', function () {
    StockPrices::shouldReceive('checkDailyPrice')->andReturn((object)['day' => '2023-10-01']);
    Log::shouldReceive('info')->once();
    $command = new StockLastAtClose();
    $result = $command->getStockPriceDataForTickerData('AAPL');
    expect($result)->toBe(1);
});
