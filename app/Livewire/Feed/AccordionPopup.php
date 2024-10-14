<?php

namespace App\Livewire\Feed;

use Livewire\Component;

class AccordionPopup extends Component
{
    public $activeIndex = null;
    public $isModalOpen = false;

    public function toggle($index)
    {
        $this->activeIndex = $index;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->activeIndex = null;
    }

    public function render()
    {
        return view('livewire.partials.accordion-popup');
    }
}
