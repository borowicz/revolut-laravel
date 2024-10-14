<?php

namespace App\Models;

use App\Models\Revolut\AbstractRevolutModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsFeed extends AbstractRevolutModel
{
    protected $fillable = [
        'disabled',
        'hash',
        'date',
//        'keep',
//        'ticker',
//        'type',
        'title',
        'feed_url',
        'comment',
    ];

    public static function getNewsFeed(string $ticker = null)
    {
        return self::select('feed_url')
//            ->when($ticker, fn($query) => $query->where('ticker', $ticker))
            ->where('disabled', 0)
            ->where('feed_url', 'LIKE', 'http%');
    }
}
