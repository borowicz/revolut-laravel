<?php

namespace App\Livewire\Revolut\Stock;

use Livewire\Component;
use App\Models\Revolut\Stock\StockMarket;
use App\Models\Revolut\Stock\StockTicker;
use App\Livewire\Revolut\AbstractComponent;

class Markets extends AbstractComponent
{
    public $itemStatus = [];
    public $sortField = 'disabled';
    public $sortDirection = 'ASC';
    public $name;
    public $short_name;
    public $symbol;
    public $suffix;
    public $suffix_ft;
    public $suffix_bb;
    public $suffix_gf;
//    public $suffix_yf;
//    public $suffix_cn;
    public $country;
    public $currency;

    public function updateStatus($itemId, $status)
    {
        $this->itemStatus[$itemId] = (int)$status === 1 ? 0 : 1;

        debugbar()->info('$status: ' . $status);
        debugbar()->info('$statusNEW: ' . $this->itemStatus[$itemId]);

        $model = StockMarket::find($itemId);
        $model->disabled = $this->itemStatus[$itemId];
        $model->save();
    }

    public function render()
    {
        $query = StockMarket::query();
        $query->orderBy($this->sortField, $this->sortDirection);
        $items = $query->get();

        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        return view('livewire.revolut.stock.markets', [
            'items' => $items,
            'hasPages' => false,
            'sortField' => '',
        ])->layout('layouts.app');
    }

    public function delete(StockMarket $item)
    {
        $item->delete();
    }
}
