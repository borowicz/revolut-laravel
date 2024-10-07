<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
//use Illuminate\Support\Facades\Schedule;

/**
 *- -***
 */
interface FetchDataInterface
{
    public function getData();

    public function setCommandSchedule(Schedule $schedule): void;
}
