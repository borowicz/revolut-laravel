<?php

namespace App\Livewire\Feed;

use Livewire\Attributes\Rule;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\NewsFeed;

class EditFeed extends ShowFeeds
{
    public NewsFeed $feed;
    public $buttonAction = 'Save';
    public $id; // Added property
    public $disabled;

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $feed_url = '';

    public function mount()
    {
        $this->feed = NewsFeed::find($this->id);
        $this->title = $this->feed->title;
        $this->feed_url = $this->feed->feed_url;
        $this->disabled = (int)$this->feed->disabled;
    }

    public function rules()
    {
        return [
            'title'    => 'required|string',
            'feed_url' => 'required|url',
            'disabled' => 'boolean',
        ];
    }

    public function save()
    {
        $this->validate();
        $this->disabled = $this->disabled ?? 0;

        $this->feed->update($this->all());

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
