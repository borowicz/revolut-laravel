<?php

namespace App\Livewire\Revolut\Stock\Tickers;

use Livewire\Component;
use App\Models\Revolut\Stock\StockTicker;
use App\Models\Revolut\Stock\StockMarket;

class EditTicker extends Component
{
    public $buttonAction = 'Save';

    public StockTicker $item;
    public $stockMarkets;

    public $id;
    public $disabled;
    public $hash = '';
    public $ticker = '';
    public $url = '';
    public $notes = '';
    public $stock_markets_id = '';
    public $entryInfo = [
        'hash' => '',
        'created_at' => '',
        'updated_at' => '',
        'deleted_at' => '',
    ];

    public function mount()
    {
        $this->item = StockTicker::find($this->id);

        $this->disabled = (int)$this->item->disabled;
        $this->hash = $this->item->hash ?? '';
        $this->ticker = $this->item->ticker ?? '';
        $this->url = $this->item->url ?? '';
        $this->notes = $this->item->notes ?? '';
        $this->stock_markets_id = $this->item->stock_markets_id ?? '';
        $this->entryInfo = [
            'hash'       => $this->item->hash ?? '',
            'created_at' => $this->item->created_at ?? '',
            'deleted_at' => $this->item->deleted_at ?? '',
            'updated_at' => $this->item->updated_at ?? '',
        ];
    }

    public function toggleDisabled(int $status)
    {
        $this->disabled = !$this->disabled;
        $this->item->update(['disabled' => $this->disabled]);
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
//            'ticker'   => $this->ticker,
            'url'      => $this->url,
            'notes'    => $this->notes,
            'stock_markets_id' => $this->stock_markets_id,
        ]);

        return redirect()->to(route('stock.tickers'));
    }

    public function render()
    {
        $this->stockMarkets = StockMarket::all();

        return view('livewire.revolut.stock.tickers-form')
            ->layout('layouts.app');
    }
}
