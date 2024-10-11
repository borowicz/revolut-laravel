<?php

namespace App\Models;

use App\Models\Revolut\AbstractRevolutModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsFeed extends AbstractRevolutModel
{
    use HasFactory;

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
}
