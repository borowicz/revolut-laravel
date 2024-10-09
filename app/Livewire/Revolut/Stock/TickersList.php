<?php

namespace App\Livewire\Revolut\Stock;

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
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($ticker = null, $perPage = 10)
    {
        parent::mount($ticker, $perPage);

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

//            $this->emit('updateStatus'); // Emit the statusUpdated event
            session()->flash('message', 'Status updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    public function render(Request $request)
    {
//        debugbar()->info('$this->perPage: ' . $this->showButtons);
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
            'livewire.revolut.stock.tickers',
            compact('items', 'hasPages')
        )
            ->layout('layouts.app');
    }

    private function getAndSetTickersFromStockTransactions(): void
    {
        $tickers = StockTransaction::getTickers();

        $new = 0;
        foreach ($tickers as $ticker) {
            $hash = AbstractRevolut::setHash([$ticker]);

            $result = StockTicker::firstOrCreate(['hash' => $hash, 'ticker' => $ticker,]);
            if (!$result) {
                $new++;
            }
        }

        session('message', 'new entries: ' . $new);
    }

    public function edit(string $ticker)
    {
//        dd($ticker);
    }

    public function details(string $ticker)
    {
//        dd($ticker);
    }
}
