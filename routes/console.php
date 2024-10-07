<?php

use Illuminate\Console\Scheduling\Schedule;

$schedule = app(Schedule::class);
foreach (
    [
        App\Console\Commands\Fetch\FetchCurrencyExchangesGoogleDrive::class,
        App\Console\Commands\Import\StockTransactions::class,
        App\Console\Commands\Import\Crypto::class,
        App\Console\Commands\Import\Commodity::class,
    ] as $commandClass
) {
    //$cmdName = (new $commandClass())->getName();
    (new $commandClass())->setCommandSchedule($schedule);
}

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();
