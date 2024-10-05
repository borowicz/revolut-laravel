<?php

namespace App\Console\Commands\Import;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Imports\AbstractImport;
use App\Console\AbstractCommand;

/**
 *- -***
 */
abstract class AbstractImportCommand extends AbstractCommand
{
    public $sourceFile;

    public function init()
    {
        parent::init();

        AbstractImport::setStats();

        $file = $this->argument('file') ?? '';
        if (!file_exists($file)) {
            $this->error('File not found: ' . $file);

            return Command::FAILURE;
        }

        $this->sourceFile = $file;

        return Command::SUCCESS;
    }

    public function isValidPdf()
    {
        $mimeType = File::mimeType($this->sourceFile);
        $extension = File::extension($this->sourceFile);

        if ($mimeType === 'application/pdf' && $extension === 'pdf') {
            return true;
        }

        return false;
    }

    public function isValidCsv()
    {
        $mimeType = mime_content_type($this->sourceFile);
        $extension = pathinfo($this->sourceFile, PATHINFO_EXTENSION);

        if ($mimeType !== 'text/csv' && $extension !== 'csv') {
            return false;
        }

        if (($handle = fopen($this->sourceFile, 'r')) !== false) {
            // Attempt to read the first line as CSV
            $header = fgetcsv($handle);

            if ($header === false) {
                $this->error('The file content is not valid CSV.');
                fclose($handle);

                return false;
            }

            // Check if the header has multiple fields
            if (count($header) > 1) {
                $this->info('The file content appears to be valid CSV.');
            } else {
                $this->error('The file content does not appear to be valid CSV.');
            }

            fclose($handle);

            return true;
        } else {
            $this->error('Failed to open the file.');
        }

        return false;
    }
}
