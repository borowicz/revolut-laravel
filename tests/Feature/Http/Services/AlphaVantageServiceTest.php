<?php

namespace Tests\Http\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Revolut\Money\CashTransaction;
use Carbon\Carbon;

it('returns null when row contains type header', function () {
    $import = new \App\Imports\MoneyAccountsTransactionsImport();
    $result = $import->model(['Type', 'Product', 'Started Date', 'Completed Date', 'Description', 'Amount', 'Fee', 'Currency', 'State', 'Balance']);
    expect($result)->toBeNull();
});

it('increments total and skips when transaction already exists', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'skipped' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'skipped' => 1]);
    CashTransaction::shouldReceive('where')->andReturnSelf();
    CashTransaction::shouldReceive('exists')->andReturn(true);
    $import = new \App\Imports\MoneyAccountsTransactionsImport();
    $result = $import->model(['CASHBACK', 'Savings', '2019-12-20 12:42:05', '2019-12-22 09:31:45', 'Metal Cashback', 0.01, 0.00, 'EUR', 'COMPLETED', 0.01]);
    expect($result)->toBeNull();
});

it('returns null when type is empty', function () {
    $import = new \App\Imports\MoneyAccountsTransactionsImport();
    $result = $import->model(['', 'Savings', '2019-12-20 12:42:05', '2019-12-22 09:31:45', 'Metal Cashback', 0.01, 0.00, 'EUR', 'COMPLETED', 0.01]);
    expect($result)->toBeNull();
});

it('creates new transaction when data is valid', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'inserted' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'inserted' => 1]);
    CashTransaction::shouldReceive('where')->andReturnSelf();
    CashTransaction::shouldReceive('exists')->andReturn(false);
    CashTransaction::shouldReceive('create')->andReturn(new CashTransaction());
    $import = new \App\Imports\MoneyAccountsTransactionsImport();
    $result = $import->model(['CASHBACK', 'Savings', '2019-12-20 12:42:05', '2019-12-22 09:31:45', 'Metal Cashback', 0.01, 0.00, 'EUR', 'COMPLETED', 0.01]);
    expect($result)->toBeInstanceOf(CashTransaction::class);
});

it('parses started date correctly', function () {
    $import = new \App\Imports\MoneyAccountsTransactionsImport();
    $result = $import->model(['CASHBACK', 'Savings', '2019-12-20 12:42:05', '2019-12-22 09:31:45', 'Metal Cashback', 0.01, 0.00, 'EUR', 'COMPLETED', 0.01]);
    expect(Carbon::parse($result->started_date)->format('Y-m-d H:i:s'))->toBe('2019-12-20 12:42:05');
});

it('parses completed date correctly', function () {
    $import = new \App\Imports\MoneyAccountsTransactionsImport();
    $result = $import->model(['CASHBACK', 'Savings', '2019-12-20 12:42:05', '2019-12-22 09:31:45', 'Metal Cashback', 0.01, 0.00, 'EUR', 'COMPLETED', 0.01]);
    expect(Carbon::parse($result->completed_date)->format('Y-m-d H:i:s'))->toBe('2019-12-22 09:31:45');
});
