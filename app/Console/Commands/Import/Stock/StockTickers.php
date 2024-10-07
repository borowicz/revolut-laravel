<?php

namespace App\Console\Commands\Import\Stock;

use App\Imports\AbstractImport;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Session;
use App\Console\Commands\Import\AbstractImportCommand;
use App\Console\FetchDataInterface;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Stock\StockTicker;
use App\Models\Revolut\Stock\StockTransaction;

/**
 * @see /revolut/stock/tickers
 *  records c.a.
 *- -***
 *
 * Class StockTickers
 */
class StockTickers extends AbstractImportCommand implements FetchDataInterface
{
    protected $signature = 'revolut:import:stock:tickers {file?}';

    protected $description = 'Fetch and store stock tickers from transactions or csv file';

    public function handle()
    {
        AbstractImport::setStats();

        $this->sourceFile = $this->argument('file') ?? '';

        $result = $this->getData();

        $this->getSummary();

        return $result;
    }

    public function getData()
    {
        if (empty($this->sourceFile)) {
            return $this->getFromDb();
        }

        return $this->getFromCsv();
    }

    public function getFromCsv()
    {
        if ($this->isValidCsv()) {
            //
        }

        $this->error('Invalid CSV file');

        return Command::FAILURE;
    }

    public function getFromDb()
    {
        $tickers = StockTransaction::getTickers();
        if (!$tickers) {
            return Command::FAILURE;
        }

        $importStats = Session::get('importStats');
        foreach ($tickers as $ticker) {
            $importStats['total']++;
            if (empty($ticker)) {
                $importStats['skipped']++;

                continue;
            }
            $row = ['ticker' => $ticker];
            $hash = AbstractRevolutController::setHash($row);

            $check = StockTicker::where(['ticker' => $ticker, 'hash' => $hash])->first();
            if ($check) {
                $importStats['skipped']++;

                continue;
            }

            StockTicker::create(['ticker' => $ticker, 'hash' => $hash]);
            $importStats['inserted']++;
        }
        Session::put('importStats', $importStats);
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command('revolut:import:stock:tickers')
            ->saturdays()
            ->at('01:23')
            ->withoutOverlapping();
    }
}
