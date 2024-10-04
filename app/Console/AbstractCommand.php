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

    public $csvFile;

    public $csvFileLocal;

    public function initImport()
    {
        $this->csvFile = $this->argument('file');
        if (!file_exists($this->csvFile)) {
            $this->error('File not found: ' . $csvFile);

            return Command::FAILURE;
        }

        $options = $this->options();
        $this->force = (($options['force'] ?? false) != 0) ?? true;

        AbstractImport::setStats();

        return Command::SUCCESS;
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

    public function getSummary()
    {
        if ($this->getOutput()->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $importStats = Session::get('importStats');
            $importStats = json_encode($importStats, JSON_PRETTY_PRINT);

            $this->info('results: ' . PHP_EOL . $importStats, OutputInterface::VERBOSITY_VERBOSE);
        }
    }
}
