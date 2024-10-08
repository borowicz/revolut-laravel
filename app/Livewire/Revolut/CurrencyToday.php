<?php

namespace App\Livewire\Revolut;

use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use App\Models\Revolut\Currency;
use App\Models\Revolut\CurrencyExchanges;
use Illuminate\Http\Request;

class CurrencyToday extends AbstractComponent
{
    public function render()
    {
        $items = [];
        $items['stocks'] = [];

        return view('livewire.revolut.currency.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
