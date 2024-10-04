<?php

namespace App\Console\Commands\Import;

use App\Console\AbstractCommand;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Console\ImportDataInterface;

/**
 *- -***
 */
abstract class AbstractImportCommand extends AbstractCommand
{

}
