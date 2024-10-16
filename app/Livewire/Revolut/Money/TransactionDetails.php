<?php

namespace App\Livewire\Revolut\Money;

use App\Livewire\Revolut\Stock\Transactions;
use Illuminate\Http\Request;
use App\Models\Revolut\Money\CashTransaction as MoneyTransactionDetails;

class TransactionDetails extends Transactions
{
    public $ticker;
    public $hash;
    public $transaction;
    public function render(Request $request, string $ticker = null)
    {
        $transaction = MoneyTransactionDetails::query()->where('hash', $this->hash)->first() ?? [];

        return view('livewire.revolut.details', ['items' => $transaction]);
    }
}
