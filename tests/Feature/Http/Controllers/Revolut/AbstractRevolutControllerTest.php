<?php

namespace Tests\Http\Controllers\Revolut;

it('generates correct hash for given array', function () {
    $array = ['key' => 'value'];
    $hash = \App\Http\Controllers\Revolut\AbstractRevolutController::setHash($array);
    expect($hash)->toBe(hash_hmac('sha1', serialize($array), config('app.key')));
});

it('formats bytes to human readable size', function () {
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::humanFileSize(1024);
    expect($result)->toBe('1.00KB');
});

it('formats large bytes to human readable size', function () {
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::humanFileSize(1048576);
    expect($result)->toBe('1.00MB');
});

it('returns fetched message for result 0', function () {
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getFetchResult('AAPL', 0);
    expect($result)->toBe('AAPL - fetched');
});

it('returns already fetched message for result 1', function () {
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getFetchResult('AAPL', 1);
    expect($result)->toBe('AAPL - already fetched');
});

it('returns no data message for result 2', function () {
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getFetchResult('AAPL', 2);
    expect($result)->toBe('AAPL - NO data');
});

it('returns unknown error message for unknown result', function () {
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getFetchResult('AAPL', 99);
    expect($result)->toBe('AAPL - unknown error');
});

it('returns last workday for Monday', function () {
    $date = '2023-10-02'; // Monday
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getLastWorkDay($date);
    expect($result)->toBe('2023-09-29'); // Last Friday
});

it('returns last workday for Sunday', function () {
    $date = '2023-10-01'; // Sunday
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getLastWorkDay($date);
    expect($result)->toBe('2023-09-29'); // Last Friday
});

it('returns yesterday for a weekday', function () {
    $date = '2023-10-03'; // Tuesday
    $result = \App\Http\Controllers\Revolut\AbstractRevolutController::getLastWorkDay($date);
    expect($result)->toBe('2023-10-02'); // Yesterday
});
