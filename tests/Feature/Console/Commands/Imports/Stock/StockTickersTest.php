<?php

namespace Tests\Console\Commands\Import\Stock;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Import\Stock\StockTickers;
use App\Models\Revolut\Stock\StockTransaction;
use App\Models\Revolut\Stock\StockTicker;
use Illuminate\Support\Facades\Session;

it('has the correct command signature', function () {
    $command = new StockTickers();
    expect($command->getName())->toBe('revolut:import:stock:tickers');
});

it('has the correct description', function () {
    $command = new StockTickers();
    expect($command->getDescription())->toBe('Fetch and store stock tickers from transactions or csv file');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new StockTickers();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('23 1 * * 6');
    expect($events[0]->command)->toBe(StockTickers::class);
});

it('fetches data from database when no file is provided', function () {
    StockTransaction::shouldReceive('getTickers')->andReturn(['AAPL', 'GOOGL']);
    Session::shouldReceive('get')->andReturn(['total' => 0, 'inserted' => 0, 'skipped' => 0]);
    Session::shouldReceive('put')->once();
    StockTicker::shouldReceive('where')->andReturn(null);
    StockTicker::shouldReceive('create')->twice();

    $command = new StockTickers();
    $result = $command->getData();
    expect($result)->toBe(Command::SUCCESS);
});

it('returns failure when no tickers are found in database', function () {
    StockTransaction::shouldReceive('getTickers')->andReturn([]);
    $command = new StockTickers();
    $result = $command->getData();
    expect($result)->toBe(Command::FAILURE);
});

it('returns failure for invalid CSV file', function () {
    $command = new StockTickers();
    $command->sourceFile = 'invalid.csv';
    $result = $command->getFromCsv();
    expect($result)->toBe(Command::FAILURE);
});
