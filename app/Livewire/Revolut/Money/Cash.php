<?php

namespace App\Livewire\Revolut\Money;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Revolut\Money\CashTransaction as Money;
use App\Livewire\Revolut\AbstractComponent;

class Cash extends AbstractComponent
{
    use WithPagination;

    public function render(Request $request)
    {
        $this->showButtons = false;
        $this->tickers = null;

        debugbar()->info('$this->perPage: ' . $this->perPage);

        $items = [];
        $hasPages = false;

        return view('livewire.revolut.money.cash', [
            'items'      => $items,
            'hasPages' => $hasPages,
        ])->layout('layouts.app');
    }
}
