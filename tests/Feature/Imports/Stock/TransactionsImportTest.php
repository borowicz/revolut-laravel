<?php

namespace Tests\Imports\Stock;

use Illuminate\Support\Facades\Session;
use App\Models\Revolut\Stock\StockTransaction;
use Carbon\Carbon;

it('returns null when row contains date header', function () {
    $import = new \App\Imports\Stock\TransactionsImport();
    $result = $import->model(['Date', 'Ticker', 'Type', 'Quantity', 'Price per share', 'Total Amount', 'Currency', 'FX Rate']);
    expect($result)->toBeNull();
});

it('increments total and skips when transaction already exists', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'skipped' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'skipped' => 1]);
    StockTransaction::shouldReceive('where')->andReturnSelf();
    StockTransaction::shouldReceive('first')->andReturn(new StockTransaction());
    $import = new \App\Imports\Stock\TransactionsImport();
    $result = $import->model(['2023-10-01', 'AAPL', 'buy', 10, 150, 1500, 'USD', 1]);
    expect($result)->toBeNull();
});

it('creates new transaction when data is valid', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'inserted' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'inserted' => 1]);
    StockTransaction::shouldReceive('where')->andReturnSelf();
    StockTransaction::shouldReceive('first')->andReturn(null);
    StockTransaction::shouldReceive('create')->andReturn(new StockTransaction());
    $import = new \App\Imports\Stock\TransactionsImport();
    $result = $import->model(['2023-10-01', 'AAPL', 'buy', 10, 150, 1500, 'USD', 1]);
    expect($result)->toBeInstanceOf(StockTransaction::class);
});

it('parses date correctly', function () {
    $import = new \App\Imports\Stock\TransactionsImport();
    $result = $import->model(['2023-10-01 12:00:00', 'AAPL', 'buy', 10, 150, 1500, 'USD', 1]);
    expect(Carbon::parse($result->date)->format('Y-m-d H:i:s'))->toBe('2023-10-01 12:00:00');
});
