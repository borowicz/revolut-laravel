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
        debugbar()->info('$this->showAll: ' . (int)$this->showAll);
        $this->tickers = $calculations->getTickersList($this->showAll)
            ->get()->pluck('ticker')->toArray();

        if (null !== $this->ticker) {
            if(in_array($this->ticker, $this->tickers)) {
                $this->tickers = [$this->ticker];
                $this->selectedTicker = $this->ticker;
            } else {
                $this->selectedTicker = null;
            }
        }

        $items = $calculations->getData(showAll: $this->showAll, tickers: $this->tickers);

        return view('livewire.revolut.stock.summary', ['items' => $items])
            ->layout('layouts.app');
    }
}
