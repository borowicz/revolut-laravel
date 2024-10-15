<?php

namespace Tests\Imports;

use Illuminate\Support\Facades\Session;
use App\Models\Revolut\Commodities\CommoditiesTransaction;
use Carbon\Carbon;

it('returns null when row contains type header', function () {
    $import = new \App\Imports\CommoditiesTransactionsImport();
    $result = $import->model(['type', 'Product', 'Started Date', 'Completed Date', 'Description', 'Amount', 'Fee', 'Currency', 'State', 'Balance']);
    expect($result)->toBeNull();
});

it('increments total and skips when transaction already exists', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'skipped' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'skipped' => 1]);
    CommoditiesTransaction::shouldReceive('where')->andReturnSelf();
    CommoditiesTransaction::shouldReceive('exists')->andReturn(true);
    $import = new \App\Imports\CommoditiesTransactionsImport();
    $result = $import->model(['buy', 'Gold', '2023-10-01', '2023-10-02', 'Description', 1000, 10, 'USD', 'completed', 10000]);
    expect($result)->toBeNull();
});

it('returns null when type is empty', function () {
    $import = new \App\Imports\CommoditiesTransactionsImport();
    $result = $import->model(['', 'Gold', '2023-10-01', '2023-10-02', 'Description', 1000, 10, 'USD', 'completed', 10000]);
    expect($result)->toBeNull();
});

it('creates new transaction when data is valid', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'inserted' => 0]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'inserted' => 1]);
    CommoditiesTransaction::shouldReceive('where')->andReturnSelf();
    CommoditiesTransaction::shouldReceive('exists')->andReturn(false);
    CommoditiesTransaction::shouldReceive('create')->andReturn(new CommoditiesTransaction());
    $import = new \App\Imports\CommoditiesTransactionsImport();
    $result = $import->model(['buy', 'Gold', '2023-10-01', '2023-10-02', 'Description', 1000, 10, 'USD', 'completed', 10000]);
    expect($result)->toBeInstanceOf(CommoditiesTransaction::class);
});

it('parses started date correctly', function () {
    $import = new \App\Imports\CommoditiesTransactionsImport();
    $result = $import->model(['buy', 'Gold', '2023-10-01 12:00:00', '2023-10-02', 'Description', 1000, 10, 'USD', 'completed', 10000]);
    expect(Carbon::parse($result->started_date)->format('Y-m-d H:i:s'))->toBe('2023-10-01 12:00:00');
});

it('parses completed date correctly', function () {
    $import = new \App\Imports\CommoditiesTransactionsImport();
    $result = $import->model(['buy', 'Gold', '2023-10-01', '2023-10-02 12:00:00', 'Description', 1000, 10, 'USD', 'completed', 10000]);
    expect(Carbon::parse($result->completed_date)->format('Y-m-d H:i:s'))->toBe('2023-10-02 12:00:00');
});
