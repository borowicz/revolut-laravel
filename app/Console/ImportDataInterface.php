<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

/**
 *- -***
 */
interface ImportDataInterface
{
    public function getData();

    public function setCommandSchedule(Schedule $schedule): void;
}
