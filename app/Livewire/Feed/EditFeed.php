<?php

namespace App\Livewire\Feed;

use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\NewsFeed;

class EditFeed extends Component
{
    public NewsFeed $item;

    public $buttonAction = 'Save';

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $content = '';

    public function mount(NewsFeed $item)
    {
        $this->item = $item;

        $this->title = $item->title;

        $this->content = $item->content;
    }

    public function save()
    {
        $this->item->update(
            $this->all()
        );

        return redirect()->to(route('feed.index'));
    }

    public function cancel()
    {
        return redirect()->to(route('feed.index'));
    }

    public function render()
    {
        return view('livewire.pages.feed.form-note')
            ->layout('layouts.app');
    }
}
