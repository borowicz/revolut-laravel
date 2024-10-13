<?php

namespace Tests\Console\Commands\Import;

use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\Commands\Import\Commodity;
use App\Imports\CommoditiesTransactionsImport;

it('has the correct command signature', function () {
    $command = new Commodity();
    expect($command->getName())->toBe('revolut:import:commodity');
});

it('has the correct description', function () {
    $command = new Commodity();
    expect($command->getDescription())->toBe('Import commodity transactions');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new Commodity();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('35 1 * * *');
    expect($events[0]->command)->toBe(Commodity::class);
});

it('imports data from a valid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(CommoditiesTransactionsImport::class), 'valid_file.csv')->andReturn(true);
    $command = new Commodity();
    $command->sourceFile = 'valid_file.csv';
    $result = $command->getData();
    expect($result)->toBeTrue();
});

it('fails to import data from an invalid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(CommoditiesTransactionsImport::class), 'invalid_file.csv')->andThrow(new \Exception('Invalid file'));
    $command = new Commodity();
    $command->sourceFile = 'invalid_file.csv';
    $result = $command->getData();
    expect($result)->toBeFalse();
});
