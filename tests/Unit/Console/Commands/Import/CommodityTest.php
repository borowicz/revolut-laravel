<?php

namespace Tests\Unit\Console\Commands\Import;

use App\Console\Commands\Import\Commodity;
use App\Imports\CommoditiesTransactionsImport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
use Maatwebsite\Excel\Facades\Excel;
use Mockery;
use PHPUnit\Framework\TestCase;

class CommodityTest extends TestCase
{
    public function imports_commodity_transactions_successfully()
    {
        Excel::fake();

        $command = new Commodity();
        $command->sourceFile = 'path/to/valid/file.csv';
        $command->getData();

        Excel::assertImported('path/to/valid/file.csv', function (CommoditiesTransactionsImport $import) {
            return true;
        });
    }

    public function does_not_import_commodity_transactions_with_invalid_file()
    {
        Excel::fake();

        $command = new Commodity();
        $command->sourceFile = 'path/to/invalid/file.csv';

        $this->expectException(\Exception::class);
        $command->getData();
    }

    public function schedules_command_daily_at_135()
    {
        $schedule = new Schedule();
        $command = new Commodity();
        $command->setCommandSchedule($schedule);

        $events = $schedule->events();
        $this->assertCount(1, $events);
        $this->assertEquals('1:35', $events[0]->expression);
    }

    public function throws_exception_if_file_not_found()
    {
        $this->expectException(\Exception::class);

        $command = new Commodity();
        $command->getData();
    }
}
