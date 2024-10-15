<?php

namespace App\Livewire\Revolut\Crypto;

use App\Models\Revolut\Stock\StockTicker;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Crypto\CryptoTransaction;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'symbol';

    public $sortDirection = 'ASC';

    public $status = 0; // Initial status
    public $itemStatus = []; // To track status for each item

    public function mount()
    {
//        $this->itemStatus = CryptoTransaction::pluck('disabled', 'id')->toArray();
    }

    public function updateStatus($itemId)
    {
//        $this->setStatusDisabled(CryptoTransaction::class, $itemId);
    }

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

        return view('livewire.revolut.crypto.tickers', ['items' => $items, 'hasPages' => $hasPages])
            ->layout('layouts.app');
    }
}
