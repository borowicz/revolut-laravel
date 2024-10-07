<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

abstract class AbstractApiService
{
    protected $client;
    public $apiName;
    protected $apiKey;
    protected $apiUrl;
    protected $apiService;
    protected $apiLocalJson = 'app/revolut/jsons/%s_%s__%s.json';
    protected $jsonFile;

    public function __construct()
    {
        $this->client = new Client();
        $this->setApiKeyUrl();
    }

    public function setApiKeyUrl()
    {
    }

    protected function getJsonFilePath(string $ticker, string $when): string
    {
        $result = sprintf($this->apiLocalJson, $when, $ticker, $this->apiService);
        $result = storage_path($result);

        return $result;
    }

    public function getJsonPath(string $ticker, string $when): string
    {
        return sprintf($this->apiLocalJson, $when, $ticker, $this->apiName);
    }

    public function storeLocalJson(mixed $data): void
    {
        file_put_contents(storage_path($this->jsonFile), json_encode($data));
    }

    public function getStockPriceData(string $ticker, string $when, bool $force = false): array
    {
        $this->jsonFile = $this->getJsonPath($when, $ticker);
        $jsonFile = storage_path($this->jsonFile);

        if (!$force) {
            if (file_exists($jsonFile)) {
                $json = file_get_contents($jsonFile);
                if (!empty($json)) {
                    return json_decode($json, true);
                }
            }
        }

        return [];
    }
}
