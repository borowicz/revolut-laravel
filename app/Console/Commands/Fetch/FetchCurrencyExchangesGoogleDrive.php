<?php

namespace App\Console\Commands\Fetch;

use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;
use App\Imports\CurrencyImport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *- -***
 */
class FetchCurrencyExchangesGoogleDrive extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:currency';

    protected $description = 'Fetch and store currency exchange from google sheet';

    protected $googleSheetUrl;

    protected $googleSheetLocalDir = 'app/revolut/csvs/';

    protected $sheets = [
            'USDEUR',
            'EURUSD',
            'PLNEUR',
            'EURPLN',
            'PLNUSD',
            'USDPLN',
        ];

    public function handle()
    {
        $this->googleSheetUrl = config('revolut.currency.gDriveCsvUrl');
        if(empty($this->googleSheetUrl)) {
            $this->error('Please set google sheet url');

            return Command::INVALID;
        }

        $this->init();
        $results = $this->getData();
        if (!$results) {
            return Command::FAILURE;
        }

        $this->getSummary();

        return Command::SUCCESS;
    }

    public function getData(): bool
    {
        $result = true;
        $stats = [
            'source'   => 'googleSheet',
            'current'  => '',
            'total'    => 0,
            'inserted' => 0,
            'skipped'  => 0,
            'sheets'   => [],
        ];

        $importStats = $stats;
        Session::put('importStats', $importStats);
        foreach ($this->sheets as $sheet) {
            $this->info(' >> sheet: ' . $sheet, OutputInterface::VERBOSITY_VERBOSE);
            $importStats = Session::get('importStats');
            $importStats['current'] = $sheet;

            $importStats['sheets'][$sheet] = $stats;
            unset(
                $importStats['sheets'][$sheet]['current'],
                $importStats['sheets'][$sheet]['source'],
                $importStats['sheets'][$sheet]['sheets']
            );

            Session::put('importStats', $importStats);

            $csv = $this->readFromCsvUrl($sheet);
            if (!$csv) {
                $result = false;
            }
        }

        return $result;
    }

    public function fetchData(string $value)
    {
        return file_get_contents($value);
    }

    public function readFromCsvUrl(string $sheet)
    {
        $localDir = storage_path($this->googleSheetLocalDir);
        $localFile = Carbon::today()->format('Ymd') . '_' . $sheet . '.csv';
        $localPath = $localDir . $localFile;

        File::ensureDirectoryExists($localDir);

        if (!file_exists($localPath)) {
            $this->info(' >> fetching sheet: ' . $sheet, OutputInterface::VERBOSITY_VERBOSE);
            $csvData = $this->fetchData($this->googleSheetUrl() . $sheet);
            if (empty(trim($csvData))) {
                $this->error('empty sheet: ' . $sheet);

                return false;
            }

            $this->info(' >> sheet count: ' . substr_count($csvData, "\n"), OutputInterface::VERBOSITY_VERBOSE);
            file_put_contents($localPath, $csvData);
        } else {
            $this->info(' >> local copy exists for sheet: ' . $sheet, OutputInterface::VERBOSITY_VERBOSE);
        }

        return Excel::import(new CurrencyImport(), $localPath);
    }

    private function googleSheetUrl()
    {
        if (null == $this->googleSheetUrl) {
            $this->googleSheetUrl = config('revolut.currency.gDriveCsvUrl');
        }

        return $this->googleSheetUrl;
    }
    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->daily()->at('6:51');
    }
}
