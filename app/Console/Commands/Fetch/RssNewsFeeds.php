<?php

namespace App\Console\Commands\Fetch;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Output\OutputInterface;
use willvincent\Feeds\Facades\FeedsFacade as Feeds;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Console\AbstractCommand;
use App\Console\FetchDataInterface;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\NewsFeed;
use App\Models\NewsFeedsItems;

/**
 * ./artisan revolut:fetch:news
 *
 *- -***
 */
class RssNewsFeeds  extends AbstractCommand implements FetchDataInterface
{
    protected $signature = 'revolut:fetch:rss';

    protected $description = 'Fetch news from rss feed and store in db, and clear old';

    public $importStats = [
        'total'    => 0,
        'inserted' => 0,
        'skipped'  => 0,
        'cached'   => 0,
        'source'   => [],
    ];

    public function handle()
    {
        $this->init();

        $this->getData();

        $this->getSummary(false);

        return Command::SUCCESS;
    }

    public function getData(): bool
    {
        $feeds = NewsFeed::getNewsFeed()->get()->pluck('feed_url')->toArray();
        foreach ($feeds as $url) {
            if (!Str::isUrl($url)) {
                continue;
            }

            $this->importStats['source'][] = $url;

            $cacheKey = 'rss_feed_' . md5($url);
            $cachedFeed = Cache::remember($cacheKey, 30 * 60, function () use ($url) {
                return $this->getRssFeed($url);
            });

            if ($cachedFeed) {
                $this->importStats['cached']++;
                $this->processFeedItems($cachedFeed);
            }
        }

        return true;
    }

    public function getRssFeed(string $rssUrl)
    {
        $feed = Feeds::make($rssUrl);

        return $feed->get_items();
    }

    public function processFeedItems($items): void
    {
        foreach ($items as $item) {
            $this->importStats['total']++;
            $url = $item->get_link();
            if (empty($url)) {
                continue;
            }
            $hash = AbstractRevolutController::setHash([$url]);

            $result = NewsFeedsItems::firstOrCreate(
                ['hash' => $hash],
                [
                    'hash'        => $hash,
                    'title'       => $item->get_title(),
                    'description' => $item->get_description(),
                    'url'         => $url,
                ]
            );

            if ($result->wasRecentlyCreated) {
                $this->importStats['inserted']++;
            } else {
                $this->importStats['skipped']++;
            }
        }
    }

    public function setCommandSchedule(Schedule $schedule): void
    {
        $schedule->command(__CLASS__, [])->everyFifteenMinutes()->withoutOverlapping();
    }
}
