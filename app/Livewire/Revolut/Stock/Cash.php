<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Note;

class Cash extends AbstractComponent
{
    public function render()
    {
        $items = [];
        $hasPages = false;

        return view('livewire.revolut.stock.cash', [
            'items' => $items,
//            'notes' => Note::where('user_id', Auth::id())->get(),
            'hasPages' => $hasPages,
        ])->layout('layouts.app');
    }

//    public function delete(Note $note)
//    {
//        $note->delete();
//    }
}
