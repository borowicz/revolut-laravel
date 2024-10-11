<?php

namespace App\Livewire\Revolut\Commodities;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Commodities\CommoditiesTransaction;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'currency';

    public $sortDirection = 'ASC';

    public $status = 0; // Initial status
    public $itemStatus = []; // To track status for each item

    public function render(Request $request)
    {
        $query = CommoditiesTransaction::getTickersList();
        $query->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        $this->showButtons = false;
        $this->tickers = null;

        return view('livewire.revolut.commodities.tickers', ['items' => $items, 'hasPages' => $hasPages])
            ->layout('layouts.app');
    }
}
