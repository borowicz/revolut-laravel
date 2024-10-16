<?php

namespace App\Livewire\Revolut\Commodities;

use App\Livewire\Revolut\AbstractTickersComponent;
use App\Models\Revolut\Commodities\CommoditiesTicker;
use App\Models\Revolut\Commodities\CommoditiesTransaction;

class TickersList extends AbstractTickersComponent
{
    public $showButtons = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $sortField = 'ticker';
    public $sortDirection = 'ASC';


    public function mount()
    {
        $this->modelTickers = CommoditiesTicker::class;
        $this->modelTransaction = CommoditiesTransaction::class;
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

        return view('livewire.revolut.commodities.tickers', [
            'items'      => $items,
            'hasPages'   => $hasPages,
        ]);
    }
}
