<?php

namespace App\Http\Services;

interface ApiInterface
{
    public function setApiKeyUrl(): void;

    public function fetchApi(string $ticker, string $when, bool $force = false): array;

    public function getItem(array $data, string $ticker): array;

    public function setItem(array $data, string $ticker): array;

    public function getStockPriceData(string $ticker, string $when, bool $force = false): array;
}
