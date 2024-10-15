<?php

use App\Console\Commands\Import\Commodity;
use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CommoditiesTransactionsImport;

it('imports commodity transactions with valid file', function () {
    Excel::fake();

    $command = new Commodity();
    $command->sourceFile = 'path/to/valid/file.csv';
    $command->getData();

    Excel::assertImported('path/to/valid/file.csv', function (CommoditiesTransactionsImport $import) {
        return true;
    });
});

it('does not import commodity transactions with invalid file', function () {
    Excel::fake();

    $command = new Commodity();
    $command->sourceFile = 'path/to/invalid/file.csv';

    $this->expectException(\Exception::class);
    $command->getData();
});

it('schedules commodity command daily at 135', function () {
    $schedule = new Schedule();
    $command = new Commodity();
    $command->setCommandSchedule($schedule);

    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('1:35');
});

it('throws exception if commodity file not found', function () {
    $this->expectException(\Exception::class);

    $command = new Commodity();
    $command->getData();
});
