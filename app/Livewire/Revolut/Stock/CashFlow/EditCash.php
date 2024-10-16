<?php

namespace App\Livewire\Revolut\Stock\CashFlow;

use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Stock\CashCurrent as Money;
use Livewire\Attributes\Rule;

class EditCash extends CreateCash
{
    public Money $item;
    public $buttonAction = 'Save';

    public function mount(Money $item)
    {
        $this->item = $item;

        $this->date = $item->date;

        $this->total = numberFormat($item->total, 2, '.', '');

        $this->note = $item->note;
    }

    public function save()
    {
        $this->total = numberFormat($this->total, 2, '.', '');
        $this->total = trim($this->total);

        $this->item->update(
            $this->all()
        );

        return redirect()->to(route($this->redirectRoute));
    }


    public function render()
    {
        return view('livewire.revolut.stock.cash-flow-form');
    }
}
