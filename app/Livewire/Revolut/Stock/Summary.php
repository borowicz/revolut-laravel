<?php

namespace App\Livewire\Revolut\Stock;

use App\Livewire\Revolut\AbstractComponent;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use App\Models\Revolut\Stock\StockPrices;
use Illuminate\Http\Request;

class Summary extends AbstractComponent
{
    public function render(StockCalculations $calculations, Request $request)
    {
        if ($request->get('all') > 0) {
            $this->showAll = true;
        }

        $this->tickers = $calculations->getTickersList($this->showAll);

        $items = $calculations->getData(showAll: $this->showAll, tickers: $this->tickers);

        return view('livewire.revolut.stock.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
