<?php

namespace App\Livewire\Revolut\Money;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Money\CashTransaction;

class Transactions extends AbstractComponent
{
    use WithPagination;

    private function getItems()
    {
        $ticker = '';

        $query = CashTransaction::query()
//            ->search($this->search)
            ->where(function ($query) use ($ticker){
                if (!empty($this->selectedTicker)) {
                    $query->where('symbol', $this->selectedTicker);
                }
                if (!empty($ticker)) {
                    $query->where('symbol', $this->ticker);
                }
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

        $this->types = CashTransaction::getTypes();
        $this->tickers = CashTransaction::getTickers();

        return view('livewire.revolut.money.transactions', [
            'hasPages' => $results['hasPages'],
            'items' => $results['items'],
        ])->layout('layouts.app');
    }
}
