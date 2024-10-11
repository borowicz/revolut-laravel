<?php

namespace App\Livewire\Feed;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Note;

class ShowFeeds extends Component
{
    public function render()
    {
        return view('livewire.pages.feed.show-notes', [
            'notes' => Note::where('user_id', Auth::id())->get(),
        ])->layout('layouts.app');
    }

    public function delete(Note $note)
    {
        $note->delete();
    }
}
