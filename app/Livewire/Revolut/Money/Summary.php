<?php

namespace App\Livewire\Revolut\Money;

use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Money\CashTransaction as MoneyTransaction;

class Summary extends AbstractComponent
{
    public function render()
    {
        $items = [];
        $items['menu'] = 'livewire.revolut.money.menu';
        $items['types'] = MoneyTransaction::getTypesSummary();
//        $items['tickers'] = MoneySummary::getSummary($this->showAll)->get();
        $items['tickers'] = [];

        return view('livewire.revolut.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
