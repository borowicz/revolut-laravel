<?php

namespace App\Livewire\Revolut\Commodities;

use App\Livewire\Revolut\Stock\AbstractRevolut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Revolut\Stock\StockTicker;
use App\Models\Revolut\Stock\StockTransaction;
use App\Livewire\Revolut\AbstractComponent;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'ticker';

    public $sortDirection = 'ASC';

    public $status = 0; // Initial status
    public $itemStatus = []; // To track status for each item

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

    public function render(Request $request)
    {
        debugbar()->info('$this->perPage: ' . $this->showButtons);

        $query = StockTicker::query();
        if ($query->count() < 1) {
            $this->getAndSetTickersFromStockTransactions();

            $query = StockTicker::query();
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        $this->showButtons = false;
        $this->tickers = null;

        return view(
                'livewire.revolut.commodities.tickers',
                compact('items', 'hasPages')
            )
            ->layout('layouts.app');
    }

    public function details(string $ticker)
    {
//        dd($ticker);
    }
}
