<?php

it('formats date to ISO8601 with default format', function () {
    $result = dateISO8601('2023-10-01');
    expect($result)->toBe('2023-10-01');
});

it('formats date to ISO8601 with custom format', function () {
    $result = dateISO8601('2023-10-01', 'd/m/Y');
    expect($result)->toBe('01/10/2023');
});

it('returns current date in ISO8601 format when no value is provided', function () {
    $result = dateISO8601();
    expect($result)->toBe(date('Y-m-d'));
});

it('formats number with default settings', function () {
    $result = numberFormat(1234.567);
    expect($result)->toBe('1 234.57');
});

it('formats number with custom settings', function () {
    $result = numberFormat(1234.567, 1, ',', '.');
    expect($result)->toBe('1.234,6');
});

it('formats currency with default settings', function () {
    $result = currencyFormat(1234.567);
    expect($result)->toBe('€1,234.57');
});

it('formats currency with custom settings', function () {
    $result = currencyFormat(1234.567, 'USD', 'en_US');
    expect($result)->toBe('$1,234.57');
});

it('shortens string to default length', function () {
    $result = shorted('This is a very long string that needs to be shortened.');
    expect($result)->toBe('This is a very long...');
});

it('shortens string to custom length', function () {
    $result = shorted('This is a very long string that needs to be shortened.', 10);
    expect($result)->toBe('This is a...');
});

it('generates news URL with valid inputs', function () {
    config(['revolut.news.test' => 'https://example.com/%s/%s']);
    config(['revolut.source' => '?source=revolut']);
    $result = newsUrl('test', 'AAPL', 'news');
    expect($result)->toBe('https://example.com/AAPL/news?source=revolut');
});

it('returns empty string for news URL with invalid news type', function () {
    config(['revolut.news.invalid' => '']);
    $result = newsUrl('invalid', 'AAPL', 'news');
    expect($result)->toBe('');
});
