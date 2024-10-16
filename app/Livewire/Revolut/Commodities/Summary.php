<?php

namespace App\Livewire\Revolut\Commodities;

use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Commodities\CommoditiesTransaction;

class Summary extends AbstractComponent
{
    public function render()
    {
        $items = [];
        $items['menu'] = 'livewire.revolut.commodities.menu';
        $items['types'] = CommoditiesTransaction::getTypesSummary();
//        $items['tickers'] = CommoditiesTransaction::getSummary($this->showAll)->get();
        $items['tickers'] = [];

        return view('livewire.revolut.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
