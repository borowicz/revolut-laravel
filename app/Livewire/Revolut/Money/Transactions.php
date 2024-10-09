<?php

namespace App\Livewire\Revolut\Money;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Stock\StockTransaction;

class Transactions extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'date';
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

    private function getItems()
    {
        $ticker = '';
//        if (!empty($this->selectedTicker)) {
//            $ticker = $this->selectedTicker;
//        }
////        if (!empty($this->ticker)) {
////            $ticker = $this->ticker;
////        }

        $query = StockTransaction::query()
//            ->search($this->search)
            ->where(function ($query) use ($ticker){
                if (!empty($this->selectedTicker)) {
                    $query->where('ticker', $this->selectedTicker);
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
        $this->types = StockTransaction::getTypes();
        $this->tickers = StockTransaction::getTickers();

        return view('livewire.revolut.money.transactions', [
            'hasPages' => $results['hasPages'],
            'items' => $results['items'],
        ])->layout('layouts.app');
    }
}
