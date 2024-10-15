<?php

namespace Tests\Unit\Console\Commands\Import;

use App\Console\Commands\Import\StockTransactions;
use App\Imports\Stock\TransactionsImport;
use Illuminate\Console\Scheduling\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Framework\TestCase;

class StockTransactionsTest extends TestCase
{
    public function imports_stock_transactions_successfully()
    {
        Excel::fake();

        $command = new StockTransactions();
        $command->sourceFile = 'path/to/valid/file.csv';
        $command->getData();

        Excel::assertImported('path/to/valid/file.csv', function (TransactionsImport $import) {
            return true;
        });
    }

    public function does_not_import_stock_transactions_with_invalid_file()
    {
        Excel::fake();

        $command = new StockTransactions();
        $command->sourceFile = 'path/to/invalid/file.csv';

        $this->expectException(\Exception::class);
        $command->getData();
    }

    public function schedules_stock_transactions_command_daily_at_111()
    {
        $schedule = new Schedule();
        $command = new StockTransactions();
        $command->setCommandSchedule($schedule);

        $events = $schedule->events();
        $this->assertCount(1, $events);
        $this->assertEquals('1:11', $events[0]->expression);
    }

    public function throws_exception_if_stock_file_not_found()
    {
        $this->expectException(\Exception::class);

        $command = new StockTransactions();
        $command->getData();
    }
}
