<?php

namespace App\Http\Services;

interface ApiInterface
{
    public function setApiKeyUrl(): void;

    public function fetchApi(string $ticker, string $when, bool $force = false): array;

    public function setItem(array $data, string $ticker): array;
}
