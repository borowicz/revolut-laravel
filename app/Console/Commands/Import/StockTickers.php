<?php

namespace App\Console\Commands\Import;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use App\Imports\AbstractImport;
use App\Console\AbstractCommand;
use App\Imports\ProfitLossImport;

class StockProfitLoss extends AbstractCommand
{
    protected $signature = 'revolut:import:stock:profit-loss {file} {--force=0}';

    protected $description = 'Fetch and store stock profit loss from csv file';

    public function handle()
    {
        $csvFile = $this->argument('file');
        if (!file_exists($csvFile)) {
            $this->error('File not found: ' . $csvFile);

            return Command::FAILURE;
        }

        $options = $this->options();
        $this->force = (($options['force'] ?? false) != 0) ?? true;

        AbstractImport::setStats();

        $result = Excel::import(new ProfitLossImport(), $csvFile);

        $this->getSummary();

        return Command::SUCCESS;
    }
}
