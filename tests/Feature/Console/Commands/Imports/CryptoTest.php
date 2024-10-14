<?php

namespace Tests\Console\Commands\Import;

use App\Console\Commands\Import\Crypto;
use App\Imports\CryptoTransactionsImport;
use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;

it('has the correct command signature', function () {
    $command = new Crypto();
    expect($command->getName())->toBe('revolut:import:crypto');
});

it('has the correct description', function () {
    $command = new Crypto();
    expect($command->getDescription())->toBe('Import crypto transactions');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new Crypto();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('47 1 * * *');
    expect($events[0]->command)->toBe(Crypto::class);
});

it('imports data from a valid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(CryptoTransactionsImport::class), 'valid_file.csv')->andReturn(true);
    $command = new Crypto();
    $command->sourceFile = 'valid_file.csv';
    $result = $command->getData();
    expect($result)->toBeTrue();
});

it('fails to import data from an invalid file', function () {
    Excel::shouldReceive('import')->with(Mockery::type(CryptoTransactionsImport::class), 'invalid_file.csv')->andThrow(new \Exception('Invalid file'));
    $command = new Crypto();
    $command->sourceFile = 'invalid_file.csv';
    $result = $command->getData();
    expect($result)->toBeFalse();
});
