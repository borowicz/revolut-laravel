<?php

namespace App\Livewire\Revolut\Stock;

use App\Models\Revolut\Stock\StockTicker;
use App\Models\Revolut\Stock\StockTransaction;
use App\Livewire\Revolut\AbstractTickersComponent;

class TickersList extends AbstractTickersComponent
{
    public $showButtons = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $sortField = 'ticker';
    public $sortDirection = 'ASC';


    public function mount()
    {
        $this->modelTickers = StockTicker::class;
        $this->modelTransaction = StockTransaction::class;
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

        return view('livewire.revolut.stock.tickers', [
            'items'      => $items,
            'hasPages'   => $hasPages,
        ]);
    }

//    public function getItems()
//    {
//        $query = $this->model::query();
//        $stockTickers = $this->modelTransaction::getTickers();
//        if ($query->count() < count($stockTickers)) {
//            $this->getAndSetTickersFromStockTransactions($stockTickers, $this->model);
//        }
//
//        $query->orderBy($this->sortField, $this->sortDirection);
//
//        return $this->setPagination($query);
//    }

//    private function getAndSetTickersFromStockTransactions(array $tickers, mixed $model): void
//    {
//        $new = 0;
//        foreach ($tickers as $ticker) {
//            $check = $this->model::where('ticker', $ticker)->first();
//            if ($check) {
//                continue;
//            }
//
//            $hash = AbstractRevolutController::setHash([$ticker]);
//            $result = $this->model::firstOrCreate(['ticker' => $ticker], ['hash' => $hash, 'ticker' => $ticker]);
//
//            if (!$result) {
//                $new++;
//            }
//        }
//
//        session('message', 'new entries: ' . $new);
//    }
}
