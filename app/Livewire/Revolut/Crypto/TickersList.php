<?php

namespace App\Livewire\Revolut\Crypto;

use App\Livewire\Revolut\AbstractTickersComponent;
use App\Models\Revolut\Crypto\CryptoTransaction;
use App\Models\Revolut\Crypto\CryptoTicker;

class TickersList extends AbstractTickersComponent
{
    public $showButtons = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $sortField = 'ticker';
    public $sortDirection = 'ASC';


    public function mount()
    {
        $this->modelTickers = CryptoTicker::class;
        $this->modelTransaction = CryptoTransaction::class;
        $this->itemStatus = $this->modelTickers::pluck('disabled', 'id')->toArray();
    }

    public function render()
    {
        $items = $this->getItems();
        $hasPages = $this->hasPagination($items);
        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }
        $this->showButtons = false;
        $this->tickers = null;

        return view('livewire.revolut.crypto.tickers', [
            'items'      => $items,
            'hasPages'   => $hasPages,
        ]);
    }
}
