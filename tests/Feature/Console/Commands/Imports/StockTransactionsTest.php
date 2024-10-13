<?php

namespace Tests\Console\Commands\Import;

use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\Commands\Import\StockTransactions;
use App\Imports\Stock\TransactionsImport;

it('has the correct command signature', function () {
    $command = new StockTransactions();
    expect($command->getName())->toBe('revolut:import:stock:transactions');
});

it('has the correct description', function () {
    $command = new StockTransactions();
    expect($command->getDescription())->toBe('Import stock transaction from csv file');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new StockTransactions();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('11 1 * * *');
    expect($events[0]->command)->toBe(StockTransactions::class);
});

it('imports data from a valid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(TransactionsImport::class), 'valid_file.csv')->andReturn(true);
    $command = new StockTransactions();
    $command->sourceFile = 'valid_file.csv';
    $result = $command->getData();
    expect($result)->toBeTrue();
});

it('fails to import data from an invalid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(TransactionsImport::class), 'invalid_file.csv')->andThrow(new \Exception('Invalid file'));
    $command = new StockTransactions();
    $command->sourceFile = 'invalid_file.csv';
    $result = $command->getData();
    expect($result)->toBeFalse();
});
