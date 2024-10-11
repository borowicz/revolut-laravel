<?php

namespace App\Console\Commands\Fetch;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Output\OutputInterface;
use Willvincent\Feeds\Facades\Feeds;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Stock\StockPrices;


/**
 * ./artisan revolut:fetch:news
 *
 *- -***
 */
class RssNews  extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:stock {ticker?} {service?} {--f|force=0}';

    protected $description = 'Fetch news from rss feed and store in db, and clear old';

    public $importStats = [
        'source'   => '',
        'total'    => 0,
        'inserted' => 0,
        'skipped'  => 0,
        'cached'   => 0,
    ];

    public function handle()
    {
        $selectedApi = $this->argument('service') ?? $this->apiSourceDefault;
        $this->apiService = $this->setApiService($selectedApi);
        $this->apiService->apiName = $selectedApi;
        $this->init();
        $this->importStats['source'] = get_class($this->apiService);

        $this->getData();

        $this->getSummary(false);

        return Command::SUCCESS;
    }

    public function getData(): bool
    {


        return true;
    }



    public function parseRss()
    {
        // URL kanału RSS
        $rssUrl = 'https://example.com/rss-feed-url';

        // Pobieranie i parsowanie RSS
        $feed = Feeds::make($rssUrl);

        // Dostęp do tytułu i elementów RSS
        $title = $feed->get_title();
        $items = $feed->get_items();

        foreach ($items as $item) {
            echo $item->get_title() . "\n";
            echo $item->get_description() . "\n";
            echo $item->get_link() . "\n";
            echo $item->get_date('j F Y | g:i a') . "\n";
        }
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->hourlyAt(59)->withoutOverlapping();
    }
}
