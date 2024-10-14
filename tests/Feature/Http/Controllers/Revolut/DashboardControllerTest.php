<?php

namespace Tests\Http\Controllers\Revolut;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Revolut\Stock\StockTransaction;

it('returns empty array when no model files are found', function () {
    File::shouldReceive('allFiles')->with(app_path('Models/Revolut'))->andReturn([]);
    $result = \App\Http\Controllers\Revolut\DashboardController::getModels();
    expect($result)->toBe([]);
});

it('returns model list when model files are found', function () {
    $files = [
        Mockery::mock(\SplFileInfo::class)->shouldReceive('getExtension')->andReturn('php')->getMock(),
        Mockery::mock(\SplFileInfo::class)->shouldReceive('getExtension')->andReturn('php')->getMock()
    ];
    File::shouldReceive('allFiles')->with(app_path('Models/Revolut'))->andReturn($files);
    Str::shouldReceive('replace')->andReturn('App\\Models\\Revolut\\Model');
    $result = \App\Http\Controllers\Revolut\DashboardController::getModels();
    expect($result)->toBe(['App\\Models\\Revolut\\Model' => 'Model']);
});

it('returns model info with valid models', function () {
    $models = ['App\\Models\\Revolut\\Model' => 'Model'];
    $modelMock = Mockery::mock('App\\Models\\Revolut\\Model');
    $modelMock->shouldReceive('count')->andReturn(10);
    $modelMock->shouldReceive('select')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('first')->andReturn((object)['updated_at' => '2023-10-01', 'created_at' => '2023-10-01']);
    $modelMock->shouldReceive('max')->andReturn('2023-10-01');
    $result = \App\Http\Controllers\Revolut\DashboardController::setModelInfo($models);
    expect($result)->toBe([
                              'App\\Models\\Revolut\\Model' => [
                                  'model' => 'App\\Models\\Revolut\\Model',
                                  'name'  => 'Model',
                                  'info'  => [
                                      'count'               => 10,
                                      'latestUpdatedRecord' => ['updated_at' => '2023-10-01',
                                                                'created_at' => '2023-10-01'],
                                      'latestUpdateTime'    => '2023-10-01'
                                  ]
                              ]
                          ]);
});

it('returns empty array when no transactions tickers are found', function () {
    $modelMock = Mockery::mock(StockTransaction::class);
    $modelMock->shouldReceive('select')->andReturnSelf();
    $modelMock->shouldReceive('where')->andReturnSelf();
    $modelMock->shouldReceive('groupBy')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('get')->andReturn(collect());
    $result = \App\Http\Controllers\Revolut\DashboardController::getTransactionsTickers($modelMock);
    expect($result)->toBe([]);
});

it('returns transactions tickers with valid data', function () {
    $modelMock = Mockery::mock(StockTransaction::class);
    $modelMock->shouldReceive('select')->andReturnSelf();
    $modelMock->shouldReceive('where')->andReturnSelf();
    $modelMock->shouldReceive('groupBy')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('get')->andReturn(collect([['ticker' => 'AAPL', 'count' => 10]]));
    $modelMock->shouldReceive('getTable')->andReturn('stock_transactions');
    \DB::shouldReceive('table')->andReturnSelf();
    \DB::shouldReceive('select')->andReturnSelf();
    \DB::shouldReceive('value')->andReturn(1000);
    $result = \App\Http\Controllers\Revolut\DashboardController::getTransactionsTickers($modelMock);
    expect($result)->toBe(['AAPL' => 'transactions: 10, cash: 1 000.00']);
});

it('returns transactions types with valid data', function () {
    $modelMock = Mockery::mock(StockTransaction::class);
    $modelMock->shouldReceive('select')->andReturnSelf();
    $modelMock->shouldReceive('groupBy')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('get')->andReturn(collect([['type' => 'buy', 'count' => 5]]));
    $result = \App\Http\Controllers\Revolut\DashboardController::getTransactionsTypes($modelMock);
    expect($result)->toBe(['buy' => 5]);
});

it('returns formatted transactions cash', function () {
    StockTransaction::shouldReceive('getTransactionsCash')->andReturn(1000);
    $result = \App\Http\Controllers\Revolut\DashboardController::getTransactionsCash(new StockTransaction());
    expect($result)->toBe('1 000.00');
});

it('returns stock transactions info with valid data', function () {
    $modelMock = Mockery::mock(StockTransaction::class);
    $modelMock->shouldReceive('select')->andReturnSelf();
    $modelMock->shouldReceive('groupBy')->andReturnSelf();
    $modelMock->shouldReceive('orderBy')->andReturnSelf();
    $modelMock->shouldReceive('get')->andReturn(collect([['type' => 'buy', 'count' => 5]]));
    StockTransaction::shouldReceive('getTransactionsCash')->andReturn(1000);
    $result = \App\Http\Controllers\Revolut\DashboardController::getInfoStockTransactions();
    expect($result)->toBe([
                              'cash top up'          => '1 000.00',
                              'transactions tickers' => ['buy' => 5],
                              'stock tickers'        => []
                          ]);
});
