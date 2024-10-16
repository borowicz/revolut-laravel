<?php

namespace App\Livewire\Revolut\Commodities;

use App\Models\Revolut\Commodities\CommoditiesTransaction;
use App\Livewire\Revolut\AbstractComponent;

class Transactions extends AbstractComponent
{
    public $sortField = 'started_date';

    private function getItems()
    {
        $query = CommoditiesTransaction::query()
            ->when($this->selectedTicker, fn($q) => $q->where('currency', $this->selectedTicker))
            ->when($this->selectedType, fn($q) => $q->where('type', $this->selectedType))
            ->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        return ['items' => $items, 'hasPages' => $hasPages];
    }

    public function render()
    {
        $results = $this->getItems();
        $this->types = CommoditiesTransaction::getTypes();
        $this->tickers = CommoditiesTransaction::getTickers();

        return view('livewire.revolut.commodities.transactions', [
            'hasPages' => $results['hasPages'],
            'items'    => $results['items'],
        ]);
    }
}
