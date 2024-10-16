<?php

namespace App\Console\Commands\Import\Stock;

use App\Console\AbstractImportCommand;
use App\Console\FetchDataInterface;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Smalot\PdfParser\Parser;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @see /revolut/stock
 *  records c.a. 800
 *- -***
 *
 * Class StockCosts
 */
class StockCosts extends AbstractImportCommand implements FetchDataInterface
{
    protected $signature = 'revolut:import:stock:cost:pdf {file}';

    protected $description = 'Import stock transaction from csv file';

    public function handle()
    {
        $this->init();
        $this->info(' >> PDF: ' . $this->sourceFile, OutputInterface::VERBOSITY_VERBOSE);

        if (!$this->isValidPdf()) {
            $this->error(' >> Invalid PDF: ' . $this->sourceFile);

            return Command::FAILURE;
        }

        $data = $this->getPdf();
        $csvFile = $this->setCsv($data);
//        $this->getData();

        $this->getSummary();

        return Command::SUCCESS;
    }

    public function getData()
    {
    }

    public function setCsv(array $data)
    {
        $csvData = '';
        foreach ($data as $row) {
            $csvData .= implode(',', $row) . "\n";
        }

        $filePath = $this->sourceFile . '.csv';

        if (File::exists($filePath)) {
            $filePath = $this->sourceFile . '__' . date('Ymd_His') . uniqid('', true) . '.csv';
        }

        File::put($filePath, $csvData);

        return $filePath;
    }

    public function getPdf()
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($this->sourceFile);

        // Get the pages from the PDF
        $pages = $pdf->getPages();

        foreach ($pages as $index => $page) {
            $text = $page->getText();

            $lines = explode("\n", $text);
            $tableData = [];

            foreach ($lines as $line) {
                $columns = preg_split('/\s+/', trim($line));

                if (count($columns) > 1) {
                    $tableData[] = $columns;
                }
            }
        }

        return $tableData;
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('1:23');
    }
}
