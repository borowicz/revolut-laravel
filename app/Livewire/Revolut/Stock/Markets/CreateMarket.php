<?php

namespace App\Livewire\Revolut\Stock\Markets;

use Livewire\Component;
use App\Models\Revolut\Stock\StockTicker;

class CreateMarket extends Component
{
    public $buttonAction = 'Create';

    public StockTicker $item;

    public $id;
    public $name = '';
    public $disabled = '';
    public $short_name = '';
    public $symbol = '';
    public $suffix = '';
    public $suffix_ft = '';
    public $suffix_bb = '';
    public $suffix_gf = '';
    public $country = '';
    public $currency = '';
    public $description = '';

    public function rules()
    {
        return [
            'name' => 'required',
            'disabled' => 'required',
        ];
    }

    public function cancel()
    {
        return redirect()->to(route('stock.markets'));
    }

    public function save()
    {
        $this->validate();

        StockMarket::create($this->all());

        return redirect()->to(route('stock.markets'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.markets-form')
            ->layout('layouts.app');
    }
}
