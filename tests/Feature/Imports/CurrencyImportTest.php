<?php

namespace Tests\Imports;

use Illuminate\Support\Facades\Session;
use App\Models\Revolut\CurrencyExchanges;
use Carbon\Carbon;
use Illuminate\Support\Str;

it('returns null when row contains date header', function () {
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model(['Date', 'Value']);
    expect($result)->toBeNull();
});

it('increments total and skips when transaction already exists', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'skipped' => 0, 'sheets' => ['USD' => ['total' => 0, 'skipped' => 0]]]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'skipped' => 1, 'sheets' => ['USD' => ['total' => 1, 'skipped' => 1]]]);
    CurrencyExchanges::shouldReceive('where')->andReturnSelf();
    CurrencyExchanges::shouldReceive('first')->andReturn(new CurrencyExchanges());
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model(['2023-10-01', '1.234']);
    expect($result)->toBeNull();
});

it('returns null when value is zero or negative', function () {
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model(['2023-10-01', '0']);
    expect($result)->toBeNull();
    $result = $import->model(['2023-10-01', '-1']);
    expect($result)->toBeNull();
});

it('returns null when date is today', function () {
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model([Carbon::today()->format('Y-m-d'), '1.234']);
    expect($result)->toBeNull();
});

it('creates new transaction when data is valid', function () {
    Session::shouldReceive('get')->with('importStats')->andReturn(['total' => 0, 'inserted' => 0, 'sheets' => ['USD' => ['total' => 0, 'inserted' => 0]]]);
    Session::shouldReceive('put')->with('importStats', ['total' => 1, 'inserted' => 1, 'sheets' => ['USD' => ['total' => 1, 'inserted' => 1]]]);
    CurrencyExchanges::shouldReceive('where')->andReturnSelf();
    CurrencyExchanges::shouldReceive('first')->andReturn(null);
    CurrencyExchanges::shouldReceive('create')->andReturn(new CurrencyExchanges());
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model(['2023-10-01', '1.234']);
    expect($result)->toBeInstanceOf(CurrencyExchanges::class);
});

it('parses date correctly', function () {
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model(['2023-10-01 12:00:00', '1.234']);
    expect(Carbon::parse($result->date)->format('Y-m-d H:i:s'))->toBe('2023-10-01 12:00:00');
});

it('formats value correctly when it contains comma', function () {
    $import = new \App\Imports\CurrencyImport();
    $result = $import->model(['2023-10-01', '1,234']);
    expect($result->exchange_rate)->toBe('1.234000');
});
