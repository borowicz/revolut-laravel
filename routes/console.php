<?php

use Illuminate\Console\Scheduling\Schedule;

$schedule = app(Schedule::class);
foreach (
    [
        App\Console\Commands\Fetch\FetchCurrencyExchangesGoogleDrive::class,
        \App\Console\Commands\Import\Stock\StockTransactions::class,
    ] as $commandClass
) {
    //$cmdName = (new $commandClass())->getName();
    (new $commandClass())->setCommandSchedule($schedule);
}

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();
