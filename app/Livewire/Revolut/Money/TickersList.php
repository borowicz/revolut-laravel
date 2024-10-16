<?php

namespace App\Livewire\Revolut\Money;

use App\Livewire\Revolut\Stock\AbstractRevolut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Revolut\Stock\StockTicker;
use App\Models\Revolut\Stock\StockTransaction;
use App\Livewire\Revolut\AbstractComponent;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'ticker';

    public $sortDirection = 'ASC';

    public $status = 0; // Initial status
    public $itemStatus = []; // To track status for each item

    public function updateStatus($itemId, $status)
    {
        $this->itemStatus[$itemId] = (int)$status === 1 ? 0 : 1;

        $model = StockTicker::find($itemId);
        $model->disabled = $this->itemStatus[$itemId];
        $model->save();
    }

    public function render(Request $request)
    {
        debugbar()->info('$this->perPage: ' . $this->showButtons);

        $query = StockTicker::query();
        if ($query->count() < 1) {
            $this->getAndSetTickersFromStockTransactions();

            $query = StockTicker::query();
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        $this->showButtons = false;
        $this->tickers = null;

        return view(
                'livewire.revolut.money.tickers',
                compact('items', 'hasPages')
            )
            ->layout('layouts.app');
    }

//    private function getAndSetTickersFromStockTransactions(): void
//    {
//        $tickers = StockTransaction::getTickers();
//
//        $new = 0;
//        foreach ($tickers as $ticker) {
//            $hash = AbstractRevolut::setHash([$ticker]);
//
//            $result = StockTicker::firstOrCreate(['hash' => $hash, 'ticker' => $ticker,]);
//            if (!$result) {
//                $new++;
//            }
//        }
//
//        session('message', 'new entries: ' . $new);
//    }

    public function details(string $ticker)
    {
//        dd($ticker);
    }
}
