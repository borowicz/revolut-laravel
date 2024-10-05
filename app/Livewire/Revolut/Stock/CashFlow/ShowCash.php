<?php

namespace App\Livewire\Revolut\Stock\CashFlow;

use App\Models\Revolut\StockMarket;
use App\Models\Revolut\StockCashCurrent;
use App\Models\Revolut\StockTicker;
use Livewire\Component;

class ShowCash extends Component
{
    public $itemStatus = [];

    public function updateStatus($itemId, $status)
    {
        $this->itemStatus[$itemId] = (int)$status === 1 ? 0 : 1;

        debugbar()->info('$status: ' . $status);
        debugbar()->info('$statusNEW: ' . $this->itemStatus[$itemId]);
        debugbar()->info('$status: ' . date('Y-m-d H:i:s') . ' - ' . uniqid('true', true));

        $model = StockTicker::find($itemId);
        $model->disabled = $this->itemStatus[$itemId];
        $model->save();
    }

    public function delete($id)
    {
        StockCashCurrent::find($id)->delete();

        session()->flash('message', 'Deleted Successfully.');
    }

    public function render()
    {
        $items = StockCashCurrent::select()->latest()->limit(10)->get();
        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled ?? 0;
        }

        return view('livewire.pages.stock.cash.show', ['items' => $items,])->layout('layouts.app');
    }
}
