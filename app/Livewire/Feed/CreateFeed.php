<?php

namespace App\Livewire\Feed;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateFeed extends Component
{
    public $buttonAction = 'Create';

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $content = '';

    public function save()
    {
        $this->validate();

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
