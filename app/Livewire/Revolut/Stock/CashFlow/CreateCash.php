<?php

namespace App\Livewire\Revolut\Stock\CashFlow;

use Livewire\Component;
use App\Livewire\Revolut\AbstractComponent;
//use App\Http\Controllers\Revolut\AbstractRevolut;
use App\Models\Revolut\Stock\CashCurrent;

class CreateCash extends AbstractComponent
{
    public $buttonAction = 'Create';
    public $today;
    public $source;
    public $when;
    public $currency;

    #[Rule('required')]
    public $cash = 0;

//    public function mount() {
//        $this->when = date('Y-m-d');
//    }

    public function save()
    {
//        $this->validate();

        $this->cash = str_replace(' ', '', $this->cash);
        $this->cash = str_replace('$', '', $this->cash);

        // $ ###,###,###.## 	$123,000.50
        if (stristr($this->cash, ',') && stristr($this->cash, '.')) {
            $this->cash = str_replace(',', '', $this->cash);
        }
        $this->cash = str_replace(',', '.', $this->cash);

        $today = date('Y-m-d');
        $hash = AbstractRevolut::setHash(['today' => $today, 'cash' => $this->cash]);

        debugbar()->info('$this->cash > 0: ' . ($this->cash > 0));
        debugbar()->info('$this->cash: ' . $this->cash);
        debugbar()->info('$hash: ' . $hash);

        if ($this->cash > 0) {
            $results = StockCashCurrent::firstOrCreate(
                ['hash' => $hash],
                [
                    'hash' => $hash,
                    'source' => $this->source ?? 'stock',
                    'when' => $today,
                    'currency' => $this->currency ?? 'USD',
                    'cash' => $this->cash ?? 0,
                ]
            );

            session()->flash('message', 'cash status updated');
        } else {
            session()->flash('error', 'Failed to set cash status!');
        }

        return redirect()->to(route('stock.cash.flow'));
    }

    public function cancel()
    {
        return redirect()->to(route('stock.cash.flow'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.cash-form', [
                'items' => CashCurrent::query()->orderBy('when', 'DESC'),
            ])
            ->layout('layouts.app');
    }
}
