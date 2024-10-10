<?php

namespace Tests\Livewire\Revolut\Stock\CashFlow;

use PHPUnit\Framework\TestCase;
use Livewire\Livewire;
use App\Models\Revolut\Stock\CashCurrent;
use App\Livewire\Revolut\Stock\CashFlow\CreateCash;

class CreateCashTest extends TestCase
{
    public function it_creates_cash_with_valid_data()
    {
        Livewire::test(CreateCash::class)
            ->set('date', '2023-10-01')
            ->set('total', 1000)
            ->set('note', 'Initial deposit')
            ->call('save')
            ->assertRedirect(route('stock.cash.flow'));

        $this->assertDatabaseHas('cash_currents', [
            'date'  => '2023-10-01',
            'total' => 1000,
            'note'  => 'Initial deposit',
        ]);
    }

    public function it_handles_missing_date()
    {
        Livewire::test(CreateCash::class)
            ->set('total', 1000)
            ->set('note', 'Initial deposit')
            ->call('save')
            ->assertHasErrors(['date' => 'required']);
    }

    public function it_handles_missing_total()
    {
        Livewire::test(CreateCash::class)
            ->set('date', '2023-10-01')
            ->set('note', 'Initial deposit')
            ->call('save')
            ->assertHasErrors(['total' => 'required']);
    }

    public function it_handles_invalid_total_format()
    {
        Livewire::test(CreateCash::class)
            ->set('date', '2023-10-01')
            ->set('total', 'invalid')
            ->set('note', 'Initial deposit')
            ->call('save')
            ->assertHasErrors(['total' => 'numeric']);
    }

    public function it_cancels_creation()
    {
        Livewire::test(CreateCash::class)
            ->call('cancel')
            ->assertRedirect(route('stock.cash.flow'));
    }
}
