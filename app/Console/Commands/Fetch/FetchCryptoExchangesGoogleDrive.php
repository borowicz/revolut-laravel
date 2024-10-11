<?php

namespace App\Console\Commands\Fetch;

use App\Console\AbstractFetchCurrencyGoogleDrive;
use Illuminate\Console\Scheduling\Schedule;

/**
 *- -***
 */
class FetchCryptoExchangesGoogleDrive extends AbstractFetchCurrencyGoogleDrive
{
    protected $signature = 'revolut:fetch:cryptos';

    protected $description = 'Fetch and store cryptos from google sheet';
    protected $sheets = [
            'BTCUSD',
//            'BTCEUR',
//            'BTCLN',
        ];

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('6:51');
    }
}
