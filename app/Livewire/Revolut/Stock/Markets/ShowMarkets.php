<?php

namespace App\Livewire\Revolut\Stock\Markets;

use App\Models\Revolut\StockMarket;
use App\Models\Revolut\StockTicker;
use Livewire\Component;

class ShowMarkets extends Component
{
    public $itemStatus = [];

    public function updateStatus($itemId, $status)
    {
        $this->itemStatus[$itemId] = (int)$status === 1 ? 0 : 1;

        debugbar()->info('$status: ' . $status);
        debugbar()->info('$statusNEW: ' . $this->itemStatus[$itemId]);

        $model = StockMarket::find($itemId);
        $model->disabled = $this->itemStatus[$itemId];
        $model->save();
    }

    public function render()
    {
        $items = StockMarket::all();
        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        return view('livewire.pages.stock.markets.show', [
            'items' => StockMarket::all(),

        ])->layout('layouts.app');
    }

    public function delete(StockMarket $item)
    {
        $item->delete();
    }
}
