<?php

namespace App\Livewire\Revolut;

use App\Models\Revolut\CurrencyExchanges;

class CurrencyToday extends AbstractComponent
{
    public function render()
    {
        $model = new CurrencyExchanges();
        $items = $model->getExchangeCurrenciesToday()->get();
        $tickers = $model->getExchangeCurrencies()->get()->toArray();

        return view('livewire.revolut.currency.summary', ['items' => $items, 'tickers' => $tickers])
            ->layout('layouts.app');
    }
}
