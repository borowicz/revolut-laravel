<?php

namespace App\Livewire\Revolut\Crypto;

use App\Livewire\Revolut\Stock\Transactions;
use Illuminate\Http\Request;
use App\Models\Revolut\Crypto\CryptoTransaction;

class TransactionDetails extends Transactions
{
    public $ticker;
    public $hash;
    public $transaction;
    public function render(Request $request, string $ticker = null)
    {
        $transaction = CryptoTransaction::query()->where('hash', $this->hash)->first() ?? [];

        return view('livewire.revolut.details', ['items' => $transaction]);
    }
}
