<?php

namespace App\Livewire\Revolut\Stock\Markets;

class ShowMarket extends EditMarket
{
    public $buttonAction = '';
    public $readOnly = true;

    public function cancel()
    {
        return redirect()->to(route('stock.markets'));
    }

    public function save()
    {
        return redirect()->to(route('stock.markets'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.markets-form')
            ->layout('layouts.app');
    }
}
