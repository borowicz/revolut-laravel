<?php

namespace App\Models;

use App\Models\Revolut\AbstractRevolutModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsFeedsItems extends AbstractRevolutModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hash',
        'title',
        'description',
        'url',
    ];
}
