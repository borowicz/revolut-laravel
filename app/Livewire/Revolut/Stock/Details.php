<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Revolut\StockTransaction;
use App\Livewire\Revolut\AbstractComponent;

class Details extends Transactions
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
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

    public function render(Request $request, string $ticker = null)
    {
        debugbar()->info('$this->perPage: ' . $this->perPage);

        $items = StockTransaction::query()
//            ->search($this->search)
//            ->where(function ($query) {
//                if (null !== $this->selectedTicker) {
//                    $query->where('ticker', $this->selectedTicker);
//                }
//            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
        ;

        $tickers = StockTransaction::query()
            ->select('ticker')
            ->distinct()
            ->orderBy('ticker')
            ->get()
            ->pluck('ticker')
            ->toArray();

        return view('livewire.pages.stock.list', [
            'selectedTicker' => $this->selectedTicker,
            'perPage' => $this->perPage,
            'tickers' => $tickers,
            'items' => $items,
        ]);
    }
}
