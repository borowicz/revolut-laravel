<?php

namespace App\Livewire\Revolut\Stock\Summary;

use App\Livewire\Revolut\AbstractComponent;
use App\Livewire\Revolut\Stock\Calculations;

class CalculatedDetails extends AbstractComponent
{
    public function render(Calculations $calculations)
    {
        $items = $calculations->getData([$this->ticker]);

        return view('livewire.pages.stock.calculated', ['items' => $items,])
            ->layout('layouts.app');
    }
}
