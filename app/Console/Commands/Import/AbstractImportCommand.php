<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use App\Imports\AbstractImport;
use App\Console\AbstractCommand;

/**
 *- -***
 */
abstract class AbstractImportCommand extends AbstractCommand
{
    public $csvFile;

    public function init()
    {
        parent::init();

        AbstractImport::setStats();

        $csvFile = $this->argument('file') ?? '';
        if (!file_exists($csvFile)) {
            $this->error('File not found: ' . $csvFile);

            return Command::FAILURE;
        }

        $this->csvFile = $csvFile;

        return Command::SUCCESS;
    }
}
