<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Stock\StockTransaction;

class Transactions extends AbstractComponent
{
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function getItems()
    {
        $query = StockTransaction::query()
            ->when($this->selectedTicker, fn($query) => $query->where('ticker', $this->selectedTicker))
            ->when($this->selectedType, fn($query) => $query->where('type', $this->selectedType))
            ->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        return ['items' => $items, 'hasPages' => $hasPages];
    }

    public function render(Request $request, string $ticker = null)
    {
        debugbar()->info('$this->perPage: ' . $this->perPage);

        $results = $this->getItems();
        $this->types = StockTransaction::getTypes();
        $this->tickers = StockTransaction::getTickers();

        return view('livewire.revolut.stock.transactions', [
            'hasPages' => $results['hasPages'],
            'items' => $results['items'],
        ])->layout('layouts.app');
    }
}
