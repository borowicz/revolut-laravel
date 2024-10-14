<?php

namespace Tests\Console\Commands\Fetch;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\Fetch\RssNewsFeeds;
use Illuminate\Support\Facades\Cache;
use willvincent\Feeds\Facades\FeedsFacade as Feeds;
use App\Models\NewsFeed;
use App\Models\NewsFeedsItems;
use Illuminate\Support\Str;

it('has the correct command signature', function () {
    $command = new RssNewsFeeds();
    expect($command->getName())->toBe('revolut:fetch:rss');
});

it('has the correct description', function () {
    $command = new RssNewsFeeds();
    expect($command->getDescription())->toBe('Fetch news from rss feed and store in db, and clear old');
});

it('sets the command schedule correctly', function () {
    $schedule = new Schedule();
    $command = new RssNewsFeeds();
    $command->setCommandSchedule($schedule);
    $events = $schedule->events();
    expect($events)->toHaveCount(1);
    expect($events[0]->expression)->toBe('*/15 * * * *');
    expect($events[0]->command)->toBe(RssNewsFeeds::class);
});

it('fetches and processes RSS feeds correctly', function () {
    Cache::shouldReceive('remember')->andReturn([]);
    Feeds::shouldReceive('make')->andReturn((object)['get_items' => []]);
    NewsFeed::shouldReceive('getNewsFeed')->andReturn(collect([(object)['feed_url' => 'http://example.com/rss']]));
    Str::shouldReceive('isUrl')->andReturn(true);

    $command = new RssNewsFeeds();
    $result = $command->getData();

    expect($result)->toBeTrue();
    expect($command->importStats['total'])->toBe(0);
    expect($command->importStats['inserted'])->toBe(0);
    expect($command->importStats['skipped'])->toBe(0);
    expect($command->importStats['cached'])->toBe(1);
    expect($command->importStats['source'])->toContain('http://example.com/rss');
});

it('processes feed items correctly', function () {
    $item = Mockery::mock();
    $item->shouldReceive('get_link')->andReturn('http://example.com/item');
    $item->shouldReceive('get_title')->andReturn('Example Title');
    $item->shouldReceive('get_description')->andReturn('Example Description');

    NewsFeedsItems::shouldReceive('firstOrCreate')->andReturn((object)['wasRecentlyCreated' => true]);

    $command = new RssNewsFeeds();
    $command->processFeedItems([$item]);

    expect($command->importStats['total'])->toBe(1);
    expect($command->importStats['inserted'])->toBe(1);
    expect($command->importStats['skipped'])->toBe(0);
});
