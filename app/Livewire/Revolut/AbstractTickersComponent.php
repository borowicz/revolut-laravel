<?php

namespace App\Livewire\Revolut;

use App\Http\Controllers\Revolut\AbstractRevolutController;
use Livewire\Component;
use Livewire\WithPagination;

abstract class AbstractTickersComponent extends AbstractComponent
{
    use WithPagination;

    public $modelTickers;
    public $modelTransaction;

    public function updateStatus(int $itemId): void
    {
        $this->setStatusDisabled($this->modelTickers, $itemId);
    }

    public function getItems()
    {
        $query = $this->modelTickers::query();
        $tickersList = $this->modelTransaction::getTickers();
        if ($query->count() < count($tickersList)) {
            $this->getAndSetTickersFromStockTransactions($tickersList, $this->modelTickers);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return $this->setPagination($query);
    }

    protected function getAndSetTickersFromStockTransactions(array $tickers, mixed $model): void
    {
        $new = 0;
        foreach ($tickers as $ticker) {
            $check = $model::where('ticker', $ticker)->first();
            if ($check) {
                continue;
            }

            $hash = AbstractRevolutController::setHash([$ticker]);
            $result = $model::firstOrCreate(['ticker' => $ticker], ['hash' => $hash, 'ticker' => $ticker]);
            if (!$result) {
                $new++;
            }
        }

        session('message', 'new entries: ' . $new);
    }
}
