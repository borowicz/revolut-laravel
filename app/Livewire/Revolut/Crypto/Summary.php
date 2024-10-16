<?php

namespace App\Livewire\Revolut\Crypto;

use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Crypto\CryptoTransaction;

class Summary extends AbstractComponent
{
    public function render()
    {
        $items = [];
        $items['menu'] = 'livewire.revolut.crypto.menu';
        $items['types'] = CryptoTransaction::getTypesSummary();
        $items['tickers'] = CryptoTransaction::getSummary($this->showAll)->get();

        return view('livewire.revolut.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
