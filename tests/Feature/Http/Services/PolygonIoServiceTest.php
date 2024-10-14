<?php

namespace Tests\Http\Services;

use App\Http\Services\PolygonIoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

it('fetchApi returns data when valid ticker and date', function () {
    $service = new PolygonIoService();
    $service->setApiKeyUrl();

    $ticker = 'AAPL';
    $date = '2024-08-07';

    $result = $service->fetchApi($ticker, $date);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('symbol', $ticker);
});

it('fetchApi returns empty array when invalid ticker', function () {
    $service = new PolygonIoService();
    $service->setApiKeyUrl();

    $ticker = 'INVALID';
    $date = '2024-08-07';

    $result = $service->fetchApi($ticker, $date);

    expect($result)->toBeArray();
    expect($result)->toBeEmpty();
});

it('fetchApi logs warning when API response is not 200', function () {
    Log::shouldReceive('warning')->once();

    $service = new PolygonIoService();
    $service->setApiKeyUrl();

    $ticker = 'AAPL';
    $date = '2024-08-07';

    $result = $service->fetchApi($ticker, $date);

    expect($result)->toBeEmpty();
});

it('setItem returns formatted data', function () {
    $service = new PolygonIoService();
    $data = [
        'symbol' => 'AAPL',
        'open' => 206.9,
        'high' => 213.64,
        'low' => 206.39,
        'close' => 209.82,
        'volume' => 60109650.0,
        'afterHours' => 208.25,
        'preMarket' => 208.3,
    ];

    $result = $service->setItem($data, 'AAPL');

    expect($result)->toBeArray();
    expect($result['symbol'])->toBe('AAPL');
    expect($result['open'])->toBe(206.9);
    expect($result['high'])->toBe(213.64);
    expect($result['low'])->toBe(206.39);
    expect($result['close'])->toBe(209.82);
    expect($result['volume'])->toBe(60109650.0);
    expect($result['afterHours'])->toBe(208.25);
    expect($result['preMarket'])->toBe(208.3);
});

//it('setApiKeyUrl sets API key from config', function () {
//    Config::set('revolut.api.polygonio', 'test_api_key');
//
//    $service = new PolygonIoService();
//    $service->setApiKeyUrl();
//
//    expect($service->apiKey)->toBe('test_api_key');
//});

//it('setApiKeyUrl sets API URL from config when API key is empty', function () {
//    Config::set('revolut.api.polygonio', '');
//    Config::set('revolut.api.polygonioUrl', 'https://test.api.url');
//
//    $service = new PolygonIoService();
//    $service->setApiKeyUrl();
//
//    expect($service->apiUrl)->toBe('https://test.api.url');
//});
