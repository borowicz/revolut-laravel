<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Revolut\Stock\StockPrices;
use App\Models\Revolut\Stock\StockTransaction;
use App\Livewire\Revolut\AbstractComponent;

class Prices  extends AbstractComponent
{
    use WithPagination;

    public $searchBox = false;
    public $sortField = 'day';
    public $sortDirection = 'DESC';

    protected $paginationTheme = 'tailwind';

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

    public function render(Request $request)
    {
        $query = StockPrices::query()
            ->where(function ($query) {
                if (!empty($this->selectedTicker)) {
                    $query->where('ticker', $this->selectedTicker);
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
//            ->paginate($this->perPage)
        ;

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        $this->tickers = StockTransaction::getTickers();
//dd($hasPages);
        return view('livewire.revolut.stock.prices', [
            'showButtons' => false,
            'items' => $items,
            'hasPages' => $hasPages,
        ])->layout('layouts.app');
    }
}
