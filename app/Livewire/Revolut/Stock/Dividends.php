<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Revolut\StockTransaction;
use App\Livewire\Revolut\AbstractComponent;

class Dividends extends Transactions
{
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

//    public function sortBy($field)
//    {
//        if ($this->sortField === $field) {
//            $this->sortDirection = $this->sortDirection === 'ASC' ? 'DESC' : 'ASC';
//        } else {
//            $this->sortField = $field;
//            $this->sortDirection = 'DESC';
//        }
//    }

    public function render(Request $request, string $ticker = null)
    {
        $query = StockTransaction::query()
            ->where(function ($query) {
                if (!empty($this->selectedTicker)) {
                    $query->where('ticker', $this->selectedTicker);
                }
            })
            ->where('type', 'LIKE', '%dividend%')
            ->orderBy($this->sortField, $this->sortDirection)
//            ->paginate($this->perPage)
        ;

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        $this->tickers = StockTransaction::getTickers();

        return view('livewire.pages.stock.dividend', [
            'selectedTicker' => $this->selectedTicker,
            'perPage' => $this->perPage,
            'tickers' => $this->tickers,
            'items' => $items,
            'hasPages' => $hasPages,
        ])->layout('layouts.app');
    }
}
