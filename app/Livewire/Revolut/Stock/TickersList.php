<?php

namespace App\Livewire\Revolut\Stock;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Livewire\Component;
use App\Http\Controllers\Revolut\AbstractRevolutController;
use App\Models\Revolut\Stock\StockTicker;
use App\Models\Revolut\Stock\StockTransaction;
use App\Livewire\Revolut\AbstractComponent;

class TickersList extends AbstractComponent
{
    use WithPagination;

    public $sortField = 'ticker';
    public $sortDirection = 'ASC';
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
//        parent::mount($ticker, $perPage);

        $this->itemStatus = StockTicker::pluck('disabled', 'id')->toArray();
    }

    public function updateStatus($itemId)
    {
        try {
            $model = StockTicker::findOrFail($itemId);
            $newStatus = $model->disabled ? 0 : 1; // Toggle status
            $model->disabled = $newStatus;
            $model->save();

            $this->itemStatus[$itemId] = $newStatus;

            session()->flash('message', 'Status updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    public function render(Request $request)
    {
        $query = StockTicker::query();
        $stockTickers = StockTransaction::getTickers();
//        dd($stockTickers);
        if ($query->count() < count($stockTickers)) {
            $this->getAndSetTickersFromStockTransactions($stockTickers);

//            $query = StockTicker::query();
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
            'livewire.revolut.stock.tickers',
            compact('items', 'hasPages')
        )
            ->layout('layouts.app');
    }

    private function getAndSetTickersFromStockTransactions(array $tickers): void
    {
        $new = 0;
        foreach ($tickers as $ticker) {
            $check = StockTicker::where('ticker', $ticker)->first();
            if ($check) {
                continue;
            }

            $hash = AbstractRevolutController::setHash([$ticker]);
            $result = StockTicker::firstOrCreate(['ticker' => $ticker], ['hash' => $hash, 'ticker' => $ticker]);

            if (!$result) {
                $new++;
            }
        }

        session('message', 'new entries: ' . $new);
    }

    public function edit(string $ticker)
    {
    }

    public function details(string $ticker)
    {
    }
}
