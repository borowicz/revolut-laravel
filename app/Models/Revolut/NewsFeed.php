<?php

namespace App\Models\Revolut;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsFeed extends AbstractRevolutModel
{
    use HasFactory;

    protected $fillable = [
        'disabled',
        'keep',
        'hash',
        'date',
        'title',
        'ticker',
        'type',
        'feed_url',
        'note',
    ];
}
