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
        $this->validate();

//        Auth::user()->notes()->create(
//            $this->only(['title', 'content'])
//        );

        return redirect()->to(route('markets.index'));
    }

    public function cancel()
    {
        return redirect()->to(route('markets.index'));
    }

    public function render()
    {
        return view('livewire.pages.stock.markets.form')
            ->layout('layouts.app');
    }
}
