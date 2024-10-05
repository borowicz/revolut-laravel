<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
//use Illuminate\Support\Facades\Schedule;

/**
 *- -***
 */
interface FetchDataInterface
{
    public function getData(): bool;

    public function fetchData(string $value);

    public function setCommandSchedule(Schedule $schedule): void;
}
