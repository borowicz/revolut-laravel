<?php

namespace Tests\Console\Commands\Import;

use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\Commands\Import\Money;
use App\Imports\MoneyAccountsTransactionsImport;

it('has the correct command signature', function () {
    $command = new Money();
    expect($command->getName())->toBe('revolut:import:money');
});

it('has the correct description', function () {
    $command = new Money();
    expect($command->getDescription())->toBe('Import money/cash accounts transactions');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new Money();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('57 1 * * *');
    expect($events[0]->command)->toBe(Money::class);
});

it('imports data from a valid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(MoneyAccountsTransactionsImport::class), 'valid_file.csv')->andReturn(true);
    $command = new Money();
    $command->sourceFile = 'valid_file.csv';
    $result = $command->getData();
    expect($result)->toBeTrue();
});

it('fails to import data from an invalid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(MoneyAccountsTransactionsImport::class), 'invalid_file.csv')->andThrow(new \Exception('Invalid file'));
    $command = new Money();
    $command->sourceFile = 'invalid_file.csv';
    $result = $command->getData();
    expect($result)->toBeFalse();
});
