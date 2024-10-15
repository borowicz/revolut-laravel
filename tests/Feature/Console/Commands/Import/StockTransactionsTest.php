<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Mockery;
use App\Console\Commands\Import\StockTransactions;

it('imports stock transactions successfully', function () {
    $file = 'path/to/valid/stock_transactions.csv';
    Artisan::call('revolut:import:stock:transactions', ['file' => $file]);
    $this->assertEquals(0, Artisan::output());
});

it('fails to import invalid csv', function () {
    $file = 'path/to/invalid/stock_transactions.csv';
    Artisan::call('revolut:import:stock:transactions', ['file' => $file]);
    $this->assertEquals(1, Artisan::output());
});

it('schedules command correctly', function () {
    $schedule = Mockery::mock(Schedule::class);
    $schedule->shouldReceive('command')
        ->once()
        ->with('revolut:import:stock:transactions', [])
        ->andReturnSelf();
    $schedule->shouldReceive('daily')->once()->andReturnSelf();
    $schedule->shouldReceive('at')->once()->with('1:11');

    $command = new StockTransactions();
    $command->setCommandSchedule($schedule);
});
