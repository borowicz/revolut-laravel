<?php

namespace App\Livewire\Revolut\Stock;

use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Revolut\Stock\StockTransaction;

class TransactionDetails extends Transactions
{
    public $ticker;
    public $hash;
    public $transaction;
    public function render(Request $request, string $ticker = null)
    {
        $transaction = StockTransaction::query()->where('hash', $this->hash)->first() ?? [];

        return view('livewire.revolut.details', ['items' => $transaction]);
    }
}
