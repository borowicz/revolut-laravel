<?php

use App\Livewire\Revolut\Stock\CashFlow\CreateCash;
use App\Models\Revolut\Stock\CashCurrent as Money;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

//uses(Tests\TestCase::class); // already
uses(RefreshDatabase::class); // already

it('creates cash with valid data', function () {

    $values = [
        'date' => date('Y-m-d'),
        'total' => 1000.000000, // precision !!!
        'note' => 'Initial deposit',
    ];

    Livewire::test(CreateCash::class)
        ->set('date', $values['date'])
        ->set('total', $values['total'])
        ->set('note', $values['note'])
        ->call('save')
        ->assertRedirect(route('stock.cash.flow'));

    $tableName = (new Money())->getTable();
    $this->assertDatabaseHas($tableName, $values);
});

it('requires date to create cash', function () {
    Livewire::test(CreateCash::class)
        ->set('total', 1000)
        ->set('note', 'Initial deposit')
        ->call('save')
        ->assertHasErrors(['date' => 'required']);
});

it('requires total to create cash', function () {

    $this->actingAs(User::find(1));

    Livewire::test(CreateCash::class)
        ->set('date', '2023-10-01')
        ->set('note', 'Initial deposit')
        ->call('save')
        ->assertHasErrors(['total' => 'required']);
});

it('redirects to the correct route on cancel', function () {
    Livewire::test(CreateCash::class)
        ->call('cancel')
        ->assertRedirect(route('stock.cash.flow'));
});
