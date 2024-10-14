<?php

namespace App\Livewire\Revolut\Stock\Markets;

use Livewire\Component;
use App\Models\Revolut\Stock\StockMarket;

class EditMarket extends Component
{
    public $readOnly = false;
    public $buttonAction = 'Save';

    public StockMarket $item;

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

    public function mount(StockMarket $item)
    {
        $this->item = StockMarket::find($this->id);

        $this->disabled = (int)$this->item->disabled;
        $this->name = $this->item->name ?? '';
        $this->short_name = $this->item->short_name ?? '';
        $this->symbol = $this->item->symbol ?? '';
        $this->suffix = $this->item->suffix ?? '';
        $this->suffix_ft = $this->item->suffix_ft ?? '';
        $this->suffix_bb = $this->item->suffix_bb ?? '';
        $this->suffix_gf = $this->item->suffix_gf ?? '';
        $this->country = $this->item->country ?? '';
        $this->currency = $this->item->currency ?? '';
        $this->description = $this->item->description ?? '';
    }

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

        $this->item->update([
            'name' => $this->name,
            'disabled' => $this->disabled,
            'short_name' => $this->short_name,
            'symbol' => $this->symbol,
            'suffix' => $this->suffix,
            'suffix_ft' => $this->suffix_ft,
            'suffix_bb' => $this->suffix_bb,
            'suffix_gf' => $this->suffix_gf,
            'country' => $this->country,
            'currency' => $this->currency,
            'description' => $this->description,
        ]);

        return redirect()->to(route('stock.markets'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.markets-form')
            ->layout('layouts.app');
    }
}
