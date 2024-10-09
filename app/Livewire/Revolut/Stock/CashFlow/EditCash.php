<?php

namespace App\Livewire\Revolut\Stock\CashFlow;

//use App\Models\Revolut\StockMarket;
//use App\Models\Revolut\StockTicker;
//use Livewire\Component;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Stock\CashCurrent;

class EditCash extends AbstractComponent
{
    public $buttonAction = 'Edit';

    public function render()
    {
        $item = CashCurrent::find($this->id);

        return view('livewire.pages.stock.cash.show', ['item' => $item,])
            ->layout('layouts.app');
    }
}
