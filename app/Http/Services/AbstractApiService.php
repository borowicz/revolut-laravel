<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

abstract class AbstractApiService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;
    protected $apiService;
    protected $apiLocalJson = 'app/revolut/jsons/%s_%s_%s.json';

    public function __construct(Client $client, string $apiKey, string $apiUrl)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    public function getStockPriceData(string $ticker, string $when, bool $force = false): array
    {
        $results = [];

        if (!$force) {
            $jsonFile = sprintf($this->apiLocalJson, $when, $ticker, $this->apiService);
            $jsonFile = storage_path($jsonFile);

            if (file_exists($jsonFile)) {
                $json = file_get_contents($jsonFile);
                if (!empty($json)) {
                    $results = json_decode($json, true);
                }
            }

            if ($results) {
                return $results;
            }
        }

        return $results;
    }
}
