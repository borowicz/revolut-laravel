<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

/**
 *- -***
 */
interface FetchDataInterface
{
    public function getData();

    public function fetchData(string $value);

    public function setModel(): void;

    public function setCommandSchedule(Schedule $schedule): void;
}
