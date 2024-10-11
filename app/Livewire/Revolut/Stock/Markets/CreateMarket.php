<?php

namespace App\Livewire\Revolut\Stock\Markets;

use Livewire\Component;

class CreateMarket extends Component
{
    public $buttonAction = 'Create';

    #[Rule('required')]
    public $title = '';

    #[Rule('required')]
    public $content = '';

    public function save()
    {
        return redirect()->to(route('markets.index'));
    }

    public function cancel()
    {
        return redirect()->to(route('markets.index'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.markets-form')
            ->layout('layouts.app');
    }
}
