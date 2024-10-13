<?php

namespace App\Console\Commands\Fetch;

use App\Console\AbstractFetchCurrencyGoogleDrive;
use Illuminate\Console\Scheduling\Schedule;

/**
 *- -***
 */
class CurrencyExchangesGoogleDrive extends AbstractFetchCurrencyGoogleDrive
{
    protected $signature = 'revolut:fetch:currency';

    protected $description = 'Fetch and store currency exchange from google sheet';
    protected $sheets = [
        'USDEUR',
        'EURUSD',
        'PLNEUR',
        'EURPLN',
        'PLNUSD',
        'USDPLN',
    ];

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('6:51');
    }
}
