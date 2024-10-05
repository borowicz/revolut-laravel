<?php

namespace App\Livewire\Revolut\Stock;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Http\Controllers\Revolut\AbstractRevolut;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\StockTicker;
use App\Models\Revolut\StockTransaction;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'ticker';

    public $status = 0; // Initial status

//    public $items; // Holds the list of items
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
//        debugbar()->info('$moswl: ' . json_encode($model, JSON_PRETTY_PRINT));
////        return $this;
//        return $this->itemStatus[$itemId];
    }

    public function updatingPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'DESC';
        }
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
//dd($items->get());
        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        $this->showButtons = false;
        $this->tickers = null;
//dd($items);
        return view('livewire.pages.stock.tickers', compact('items', 'hasPages'))
            ->layout('layouts.app');
    }

    private function getAndSetTickersFromStockTransactions(): void
    {
        $tickers = StockTransaction::getTickers();

        foreach ($tickers as $ticker) {
            $hash = AbstractRevolut::setHash([$ticker]);

            $result = StockTicker::firstOrCreate(['hash' => $hash, 'ticker' => $ticker,]);
//            session('message');
        }
    }

    public function details(string $ticker)
    {
        dd($ticker);
    }
}
