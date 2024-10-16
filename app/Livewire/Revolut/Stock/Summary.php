<?php

namespace App\Livewire\Revolut\Stock;

use App\Livewire\Revolut\AbstractComponent;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use App\Models\Revolut\Stock\StockTicker;
use Illuminate\Http\Request;

class Summary extends AbstractComponent
{
    public $detailsView = false;
    public $tickerChart;
    public $markets = [];

    public function render(StockCalculations $calculations, Request $request)
    {
        if ($request->get('all') > 0) {
            $this->showAll = true;
        }

        $query = $calculations->getTickersList($this->showAll);
        $this->tickers = $query->get()->pluck('ticker')->toArray();

        if (null !== $this->ticker) {
            if(in_array($this->ticker, $this->tickers)) {
                $this->tickers = [$this->ticker];
                $this->selectedTicker = $this->ticker;
                $this->detailsView = true;
                $market = StockTicker::where('ticker', $this->ticker)->get()->first()->symbol;

                $this->tickerChart = $market . ':' . $this->ticker;
            } else {
                $this->selectedTicker = null;
            }
        }

        $items = $calculations->getData(showAll: $this->showAll, tickers: $this->tickers);

        return view('livewire.revolut.stock.summary', [
            'detailsView' => $this->detailsView,
            'items' => $items
        ]);
    }
}
