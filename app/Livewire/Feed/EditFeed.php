<?php

namespace App\Livewire\Feed;

use App\Models\Note;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditFeed extends Component
{
    public Note $note;
    public $buttonAction = 'Save';

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $content = '';

    public function mount(Note $note)
    {
        $this->note = $note;

        $this->title = $note->title;

        $this->content = $note->content;
    }

    public function save()
    {
        $this->note->update(
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
