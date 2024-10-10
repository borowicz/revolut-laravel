<?php

namespace App\Livewire\Revolut\Crypto;


use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\Stock\AbstractRevolut;
use App\Models\Revolut\Crypto\CryptoTransaction;
use App\Livewire\Revolut\AbstractComponent;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'symbol';

    public $sortDirection = 'ASC';

    public $status = 0; // Initial status
    public $itemStatus = []; // To track status for each item

    public function render(Request $request)
    {
        $query = CryptoTransaction::getTickersList();
        $query->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        $this->showButtons = false;
        $this->tickers = null;

        return view(compact('items', 'hasPages'))
            ->layout('layouts.app');
    }
}
