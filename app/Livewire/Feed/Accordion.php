<?php

namespace App\Livewire\Feed;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Accordion extends Component
{
    public $activeIndex = null;

    public function toggle($index)
    {
        $this->activeIndex = $this->activeIndex === $index ? null : $index;
    }

    public function render()
    {
        return view('livewire.partials.accordion');
    }
}
