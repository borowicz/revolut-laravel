<?php

namespace App\Livewire\Revolut\Stock\Markets;

use App\Models\Revolut\StockMarket;
use Livewire\Component;

class EditMarket extends Component
{
    public $buttonAction = 'Save';

    public StockMarket $item;

    #[Rule('required')]
    public $name = '';

    #[Rule('required')]
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
        $this->item = $item;

        $this->disabled = (int)$item->disabled;
        $this->name = $item->name ?? '';
        $this->short_name = $item->short_name ?? '';

        $this->symbol = $item->symbol ?? '';

        $this->suffix = $item->suffix ?? '';
        $this->suffix_ft = $item->suffix_ft ?? '';
        $this->suffix_bb = $item->suffix_bb ?? '';
        $this->suffix_gf = $item->suffix_gf ?? '';

        $this->country = $item->country ?? '';
        $this->currency = $item->currency ?? '';

        $this->description = $item->description ?? '';
    }

    public function cancel()
    {
        return redirect()->to(route('markets.index'));
    }

    public function save()
    {
        $this->item->update(
            $this->all()
        );

        return redirect()->to(route('markets.index'));
    }

    public function render()
    {
        return view('livewire.pages.stock.markets.form')
            ->layout('layouts.app');
    }
}
