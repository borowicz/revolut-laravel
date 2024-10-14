<?php

namespace Tests\Console\Commands\Fetch;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Fetch\CurrencyExchangesGoogleDrive;

it('has the correct command signature', function () {
    $command = new CurrencyExchangesGoogleDrive();
    expect($command->getName())->toBe('revolut:fetch:currency');
});

it('has the correct description', function () {
    $command = new CurrencyExchangesGoogleDrive();
    expect($command->getDescription())->toBe('Fetch and store currency exchange from google sheet');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new CurrencyExchangesGoogleDrive();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('51 6 * * *');
    expect($events[0]->command)->toBe(CurrencyExchangesGoogleDrive::class);
});

it('has the correct sheets array', function () {
    $command = new CurrencyExchangesGoogleDrive();
    expect($command->sheets)->toBe([
                                       'USDEUR',
                                       'EURUSD',
                                       'PLNEUR',
                                       'EURPLN',
                                       'PLNUSD',
                                       'USDPLN',
                                   ]);
});
