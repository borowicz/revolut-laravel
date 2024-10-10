<?php

namespace App\Livewire\Revolut\Commodities;

use Livewire\Component;
use App\Models\Revolut\Commodities\CommoditiesTransaction;
use App\Livewire\Revolut\AbstractComponent;

class Transactions extends AbstractComponent
{
    public $selectedTicker = '';
    public $selectedType = '';
    public $sortField = 'completed_date';
    public $sortDirection = 'asc';
    public $perPage = 10;

    private function getItems()
    {
        $query = CommoditiesTransaction::query()
            ->when($this->selectedTicker, fn($q) => $q->where('currency', $this->selectedTicker))
            ->when($this->selectedType, fn($q) => $q->where('type', $this->selectedType))
            ->orderBy($this->sortField, $this->sortDirection);

        $items = $query->paginate($this->perPage);

        return ['items' => $items, 'hasPages' => $items->hasMorePages()];
    }

    public function render()
    {
        $results = $this->getItems();
        $this->types = CommoditiesTransaction::getTypes();
        $this->tickers = CommoditiesTransaction::getTickers();

        return view('livewire.revolut.commodities.transactions', [
            'hasPages' => $results['hasPages'],
            'items'    => $results['items'],
        ])->layout('layouts.app');
    }
}
