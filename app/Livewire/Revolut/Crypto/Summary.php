<?php

namespace App\Livewire\Revolut\Crypto;

use App\Livewire\Revolut\AbstractComponent;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use Illuminate\Http\Request;

class Summary extends AbstractComponent
{
    public function render(StockCalculations $calculations, Request $request)
    {
        $items = [];
        $items['stocks'] = [];

        return view('livewire.revolut.crypto.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
