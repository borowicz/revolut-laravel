<?php

namespace App\Livewire\Note;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateNote extends Component
{
    public $buttonAction = 'Create';

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $content = '';

    public function save()
    {
        $this->validate();

        Auth::user()->notes()->create(
            $this->only(['title', 'content'])
        );

        return redirect()->to(route('notes.index'));
    }

    public function cancel()
    {
        return redirect()->to(route('notes.index'));
    }

    public function render()
    {
        return view('livewire.pages.notes.form-note')
            ->layout('layouts.app');
    }
}
