<?php

namespace App\Livewire\Revolut\Stock;

use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use App\Livewire\Revolut\AbstractComponent;
use App\Models\Revolut\Stock\CashCurrent as Money;

class CashFlow extends AbstractComponent
{
    use WithPagination;



    public function render()
    {
        $query = Money::query();
        $query->orderBy($this->sortField, $this->sortDirection);;

        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        return view('livewire.revolut.stock.cash-flow', [
            'showButtons' => false,
            'items' => $items,
            'hasPages' => $hasPages,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->buttonAction = 'Create';
        $this->when = date('Y-m-d H:i:s');
        $this->cash = 0;

        $this->validate();

        Money::create(
            $this->only(['title', 'content'])
        );

        return redirect()->to(route('notes.index'));
    }

    public function delete(Money $item)
    {
        $item->delete();
    }
}
