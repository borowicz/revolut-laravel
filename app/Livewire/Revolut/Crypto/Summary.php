<?php

namespace App\Livewire\Revolut\Crypto;

use Illuminate\Http\Request;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Crypto\CryptoTransaction;

class Summary extends AbstractComponent
{
    public function render(Request $request)
    {
        $items = [];
        $items['types'] = CryptoTransaction::getTypesSummary();
        $items['crypto'] = CryptoTransaction::getSummary($this->showAll)->get();

        return view('livewire.revolut.crypto.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
