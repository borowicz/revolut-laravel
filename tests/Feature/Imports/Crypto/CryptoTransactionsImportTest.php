<?php

namespace Tests\Imports\Crypto;

use App\Models\Revolut\Crypto\CryptoTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

it('returns null when row contains symbol header', function () {
    $import = new \App\Imports\CryptoTransactionsImport();
    $result = $import->model(['symbol', 'Type', 'Quantity', 'Price', 'Value', 'Fees', 'Date']);
    expect($result)->toBeNull();
});

it('increments total and skips when transaction already exists', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'skipped' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'skipped' => 1]);
    CryptoTransaction::shouldReceive('where')->andReturnSelf();
    CryptoTransaction::shouldReceive('first')->andReturn(new CryptoTransaction());
    $import = new \App\Imports\CryptoTransactionsImport();
    $result = $import->model(['BTC', 'buy', 1, 50000, 50000, 10, '2023-10-01']);
    expect($result)->toBeNull();
});

it('returns null when symbol is empty', function () {
    $import = new \App\Imports\CryptoTransactionsImport();
    $result = $import->model(['', 'buy', 1, 50000, 50000, 10, '2023-10-01']);
    expect($result)->toBeNull();
});

it('creates new transaction when data is valid', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'inserted' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'inserted' => 1]);
    CryptoTransaction::shouldReceive('where')->andReturnSelf();
    CryptoTransaction::shouldReceive('first')->andReturn(null);
    CryptoTransaction::shouldReceive('create')->andReturn(new CryptoTransaction());
    $import = new \App\Imports\CryptoTransactionsImport();
    $result = $import->model(['BTC', 'buy', 1, 50000, 50000, 10, '2023-10-01']);
    expect($result)->toBeInstanceOf(CryptoTransaction::class);
});

it('parses date correctly', function () {
    $import = new \App\Imports\CryptoTransactionsImport();
    $result = $import->model(['BTC', 'buy', 1, 50000, 50000, 10, '2023-10-01 12:00:00']);
    expect(Carbon::parse($result->date)->format('Y-m-d H:i:s'))->toBe('2023-10-01 12:00:00');
});
