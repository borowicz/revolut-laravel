<?php

namespace App\Livewire\Revolut\Commodities;

use App\Livewire\Revolut\Stock\Transactions;
use Illuminate\Http\Request;
use App\Models\Revolut\Commodities\CommoditiesTransaction;

class TransactionDetails extends Transactions
{
    public $ticker;
    public $hash;
    public $transaction;
    public function render(Request $request, string $ticker = null)
    {
        $transaction = CommoditiesTransaction::query()->where('hash', $this->hash)->first() ?? [];

        return view('livewire.revolut.details', ['items' => $transaction]);
    }
}
