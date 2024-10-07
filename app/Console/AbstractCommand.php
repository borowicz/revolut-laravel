<?php

namespace App\Console;

use Carbon\Carbon;
use Symfony\Component\Console\Output\OutputInterface;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

/**
 *- -***
 */
abstract class AbstractCommand extends Command
{
    public $model;
    public $isDeBug;

    public $force = false;

    public $options = [];

    public $sourceFile;

    public $csvFileLocal;

    public function init()
    {
        $this->options = $this->options() ?? [];
        $this->force = (empty($this->options['force'])) ? false : true;

        $this->getVerbosity();
    }

    public function getVerbosity()
    {
        if (null === $this->isDeBug) {
            $this->isDeBug = false;
            if ($this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_DEBUG) {
                $this->isDeBug = true;
            }
        }

        return $this->isDeBug;
    }

    public function getSummary(bool $session = true, bool $saveLog = false): void
    {
        if ($this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            if ($session) {
                $importStats = Session::get('importStats');
            } else {
                $importStats = $this->importStats;
            }

            $importStats = json_encode($importStats, JSON_PRETTY_PRINT);

            $this->info('results: ' . PHP_EOL . $importStats, OutputInterface::VERBOSITY_VERBOSE);
        }

        if ($saveLog) {
            $this->storeLog();
        }
    }

    public function storeLog()
    {

    }
}
