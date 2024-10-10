<?php

namespace App\Livewire\Revolut\Stock\CashFlow;

use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Stock\CashCurrent as Money;
use Livewire\Attributes\Rule;

class CreateCash extends AbstractComponent
{
    public $buttonAction = 'Create';
//    public Money $item;

    #[Rule('required')]
    public $date = '';

    #[Rule('required')]
    public $total = 0;
    public $note = '';

    public $redirectRoute = 'stock.cash.flow';

    public function save()
    {
//        dd($this->all());
        Money::create($this->only(['date', 'total', 'note']));

        return redirect()->to(route($this->redirectRoute));
    }

    public function cancel()
    {
        return redirect()->to(route($this->redirectRoute));
    }

    public function render()
    {
        $this->date = date('Y-m-d');

        return view('livewire.revolut.stock.cash-flow-form')
            ->layout('layouts.app');
    }
}
