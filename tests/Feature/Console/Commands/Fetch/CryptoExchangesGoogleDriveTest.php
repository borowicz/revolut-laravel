<?php

namespace Tests\Console\Commands\Fetch;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Fetch\CryptoExchangesGoogleDrive;

it('has the correct command signature', function () {
    $command = new CryptoExchangesGoogleDrive();
    expect($command->getName())->toBe('revolut:fetch:cryptos');
});

it('has the correct description', function () {
    $command = new CryptoExchangesGoogleDrive();
    expect($command->getDescription())->toBe('Fetch and store cryptos from google sheet');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new CryptoExchangesGoogleDrive();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('51 6 * * *');
    expect($events[0]->command)->toBe(CryptoExchangesGoogleDrive::class);
});
