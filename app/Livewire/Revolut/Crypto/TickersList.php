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

    public function updateStatus($itemId, $status)
    {
        $this->itemStatus[$itemId] = (int)$status === 1 ? 0 : 1;

        debugbar()->info('$status: ' . $status);
        debugbar()->info('$statusNEW: ' . $this->itemStatus[$itemId]);
        debugbar()->info('$status: ' . date('Y-m-d H:i:s') . ' - ' . uniqid('true', true));

        $model = StockTicker::find($itemId);
        $model->disabled = $this->itemStatus[$itemId];
        $model->save();
    }

    public function render(Request $request)
    {
        debugbar()->info('$this->perPage: ' . $this->showButtons);

        $query = CryptoTransaction::query();

        $query->orderBy($this->sortField, $this->sortDirection);

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        foreach ($items as $item) {
            $this->itemStatus[$item->id] = $item->disabled;
        }

        $this->showButtons = false;
        $this->tickers = null;

        return view(
                'livewire.revolut.stock.tickers',
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
        dd($ticker);
    }
}
