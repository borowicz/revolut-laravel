<?php

namespace Tests\Livewire\Revolut\Stock\CashFlow;

//use Tests\TestCase;
use PHPUnit\Framework\TestCase;
use App\Livewire\Revolut\Stock\CashFlow\EditCash;
use App\Models\Revolut\Stock\CashCurrent;

use Livewire\Livewire;
class EditCashTest extends TestCase
{
    public function it_mounts_with_existing_item()
    {
        $item = CashCurrent::factory()->create();

        Livewire::test(EditCash::class, ['item' => $item])
            ->assertSet('item', $item)
            ->assertSet('date', $item->date)
            ->assertSet('total', number_format($item->total, 2, '.', ''))
            ->assertSet('note', $item->note);
    }

    public function it_saves_item_with_updated_values()
    {
        $item = CashCurrent::factory()->create();
        $newTotal = '1234.56';
        $newNote = 'Updated note';

        Livewire::test(EditCash::class, ['item' => $item])
            ->set('total', $newTotal)
            ->set('note', $newNote)
            ->call('save')
            ->assertRedirect(route('your.redirect.route'));

        $this->assertDatabaseHas('cash_currents', [
            'id' => $item->id,
            'total' => $newTotal,
            'note' => $newNote,
        ]);
    }

    public function it_handles_empty_total()
    {
        $item = CashCurrent::factory()->create();

        Livewire::test(EditCash::class, ['item' => $item])
            ->set('total', '')
            ->call('save')
            ->assertHasErrors(['total' => 'required']);
    }

    public function it_handles_invalid_total_format()
    {
        $item = CashCurrent::factory()->create();

        Livewire::test(EditCash::class, ['item' => $item])
            ->set('total', 'invalid')
            ->call('save')
            ->assertHasErrors(['total' => 'numeric']);
    }
}
