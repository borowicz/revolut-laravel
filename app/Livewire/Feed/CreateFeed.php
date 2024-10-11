<?php

namespace App\Livewire\Feed;

use Livewire\Attributes\Rule;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\NewsFeed;

class CreateFeed extends ShowFeeds
{
    public $buttonAction = 'Create';
    public NewsFeed $item;

//    public $keep;
    public $disabled;
    public $hash;
    public $date;
//    public $ticker;
//    public $type;
    public $comment;

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $feed_url = '';

    public function rules()
    {
        return [
            'title'    => 'required|string',
            'feed_url' => 'required|string',
        ];
    }

    public function save()
    {
        $this->validate();
        $this->hash = AbstractRevolutController::setHash([$this->feed_url]);
        $this->disabled = 0;
        $this->keep = 0;
        $this->ticker = null;
        $this->type = null;

        NewsFeed::create($this->all());

        return redirect()->to(route('feeds.index'));
    }

    public function cancel()
    {
        return redirect()->to(route('feeds.index'));
    }

    public function render()
    {
        return view('livewire.pages.feeds.form')
            ->layout('layouts.app');
    }
}
