<?php

namespace App\Livewire\Revolut\Commodities;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Crypto\CryptoTransaction;

class Transactions extends AbstractComponent
{
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    private function getItems()
    {
        $query = CryptoTransaction::query()
//            ->search($this->search)
            ->where(function ($query) use ($ticker){
                if (!empty($this->selectedTicker)) {
                    $query->where('symbol', $this->selectedTicker);
                }
//                if (!empty($ticker)) {
//                    $query->where('ticker', $this->ticker);
//                }
                if (!empty($this->selectedType)) {
                    $query->where('type', $this->selectedType);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        return ['items' => $items, 'hasPages' => $hasPages];
    }

    public function render(Request $request, string $ticker = null)
    {
        debugbar()->info('$this->perPage: ' . $this->perPage);

        $results = $this->getItems();

        $this->types = CryptoTransaction::getTypes();
        $this->tickers = CryptoTransaction::getTickers();

        return view('livewire.revolut.commodities.transactions', [
            'hasPages' => $results['hasPages'],
            'items' => $results['items'],
        ])->layout('layouts.app');
    }
}
