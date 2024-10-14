<?php

namespace App\Livewire\Note;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Note;

class ShowNotes extends Component
{
    public function render()
    {
        return view('livewire.pages.notes.show-notes', [
            'notes' => Note::where('user_id', Auth::id())->get(),
        ])->layout('layouts.app');
    }

    public function delete(Note $note)
    {
        $note->delete();
    }
}
