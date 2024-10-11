<?php

use Illuminate\Console\Scheduling\Schedule;

$schedule = app(Schedule::class);
foreach (
    [
        App\Console\Commands\Fetch\CryptoExchangesGoogleDrive::class,
        App\Console\Commands\Fetch\CurrencyExchangesGoogleDrive::class,
        App\Console\Commands\Fetch\StockLastAtClose::class,
        App\Console\Commands\Fetch\RssNewsFeeds::class,

        App\Console\Commands\Import\Commodity::class,
        App\Console\Commands\Import\Crypto::class,
        App\Console\Commands\Import\Money::class,
        App\Console\Commands\Import\StockTransactions::class,
    ] as $commandClass
) {
    //$cmdName = (new $commandClass())->getName();
    (new $commandClass())->setCommandSchedule($schedule);
}

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();
