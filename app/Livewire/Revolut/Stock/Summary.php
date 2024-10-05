<?php

namespace App\Livewire\Revolut\Stock;

use App\Livewire\Revolut\AbstractComponent;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use Illuminate\Http\Request;

class Summary extends AbstractComponent
{
    public function render(StockCalculations $calculations, Request $request)
    {
//        if ($request->get('all') > 0) {
//            $this->showAll = true;
//        }
//
//        $items = $calculations->getData(showAll: $this->showAll);
        $items = [];
        $items['stocks'] = [];

        return view('livewire.revolut.stock.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
