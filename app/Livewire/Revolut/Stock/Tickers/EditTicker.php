<?php

namespace App\Livewire\Revolut\Stock\Tickers;

use Livewire\Component;
use App\Models\Revolut\Stock\StockTicker;

class EditTicker extends Component
{
    public $buttonAction = 'Save';

    public StockTicker $item;

    public $id;
    public $disabled = '';
    public $hash = '';
    public $ticker = '';
    public $url = '';
    public $notes = '';

    public function mount(StockTicker $item)
    {
        $this->item = StockTicker::find($this->id);

        $this->disabled = (int)$this->item->disabled;
        $this->hash = $this->item->hash ?? '';
        $this->ticker = $this->item->ticker ?? '';
        $this->url = $this->item->url ?? '';
        $this->notes = $this->item->notes ?? '';
    }

    public function rules()
    {
        return [
            'disabled' => 'required',
            'ticker'   => 'required',
        ];
    }

    public function cancel()
    {
        return redirect()->to(route('stock.tickers'));
    }

    public function save()
    {
        $this->validate();

        $this->item->update([
            'disabled' => $this->disabled,
            'ticker'   => $this->ticker,
            'url'      => $this->url,
            'notes'    => $this->notes,
        ]);

        return redirect()->to(route('stock.tickers'));
    }

    public function render()
    {
        return view('livewire.revolut.stock.tickers-form')
            ->layout('layouts.app');
    }
}
