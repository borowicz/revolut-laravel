<?php

namespace App\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *- -***
 */
abstract class AbstractCsvImport extends AbstractImportCommand
{
    public function handle()
    {
        $this->init();
        $this->info(' >> CSV: ' . $this->sourceFile, OutputInterface::VERBOSITY_VERBOSE);

        if (!$this->isValidCsv()) {
            $this->error(' >> Invalid CSV: ' . $this->sourceFile);

            return Command::FAILURE;
        }

        $this->getData();

        $this->getSummary();

        return Command::SUCCESS;
    }
}
