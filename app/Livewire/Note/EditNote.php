<?php

namespace App\Livewire\Note;

use App\Models\Note;
use Livewire\Attributes\Rule;
use Livewire\Component;

class EditNote extends Component
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
