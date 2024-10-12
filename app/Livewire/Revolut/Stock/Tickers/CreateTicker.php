<?php

namespace App\Livewire\Revolut\Stock\Tickers;

use Livewire\Component;
use App\Models\Revolut\Stock\StockTicker;
class CreateTicker extends Component
{
    public $buttonAction = 'Create';

    public StockTicker $item;

    public $id;
    public $disabled = '';
    public $hash = '';
    public $ticker = '';
    public $url = '';
    public $notes = '';

    public function rules()
    {
        return [
            'disabled' => 'required',
            'ticker' => 'required',
        ];
    }

    public function cancel()
    {
        return redirect()->to(route('stock.tickers'));
    }

    public function save()
    {
        $this->validate();

        StockTicker::create($this->all());

        return redirect()->to(route('stock.tickers'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.tickers-form')
            ->layout('layouts.app');
    }
}
