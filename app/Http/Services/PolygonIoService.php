<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class PolygonIoService extends AbstractApiService implements ApiInterface
{
    protected $apiUrl = 'https://api.polygon.io/v1/open-close/';
    protected $sleepDelay = 15; // second delay between, free tier: 5 requests per minute
    public function setApiKeyUrl(): void
    {
        $this->apiKey = config('revolut.api.polygonio');
        if (empty($this->apiKey)) {
            $this->apiUrl = config('revolut.api.polygonioUrl');
        }
    }

    public function getStockPriceData(string $ticker, string $when, bool $force = false): array
    {
//        $results = parent::getStockPriceData($ticker, $when, $force);

        $localCache = parent::getStockPriceData($ticker, $when, $force);
        if ($localCache) {
            return $localCache;
        }

        return $this->fetchApi($ticker, $when, $force);
    }

    public function fetchApi(string $ticker, string $when, bool $force = false): array
    {
        // polygon.io/docs/stocks/get_v1_open-close__stocksticker___date
        $queryParams = [
            'adjusted' => 'true',
            'apikey'   => $this->apiKey,
        ];

        $apiUrl = $this->apiUrl . $ticker . '/' . $when;

        try {
            $response = $this->client->request('GET', $apiUrl, [
                'query' => $queryParams
            ]);
        } catch (\Exception $e) {
            Log::warning($this->apiName . ' - ' . $e->getMessage());

            throw new \Exception($e->getMessage());
        }

        if ($response && 200 !== $response?->getStatusCode()) {
            Log::warning($this->apiName . ' - ' . $statusCode);
        }

        $body = $response->getBody();
        $data = json_decode($body, true);

        if($ticker !== $data['symbol']) {
            $msg = 'Invalid ticker: ' . $ticker . ' != ' . $data['symbol'];
            throw new \Exception($msg);
        }

        $result = $this->setItem($data, $ticker);

        if ($this->sleepDelay) {
            sleep($this->sleepDelay);
        }

        file_put_contents(storage_path($this->jsonFile), json_encode($result));

        return $result;
    }

    public function getItem($data, $ticker): array
    {
        return [];
    }
//    {
////        $result = [];
//
////        dd($data);
//
//        $result = [
//            'info' => [],
//            'ticker' => $ticker,
//            'refreshed' => $data['refreshed'],
//            'items' => $data['items'],
//        ];
//
//        return $result;
//    }

    public function setItem(array $data, string $ticker): array
    {
//x@mielec-web:/var/www/html/rev$ ./artisan stock:fetch AAPL polygonio
//array:10 [
//  "status" => "OK"
//  "from" => "2024-08-07"
//  "symbol" => "AAPL"
//  "open" => 206.9
//  "high" => 213.64
//  "low" => 206.39
//  "close" => 209.82
//  "volume" => 60109650.0
//  "afterHours" => 208.25
//  "preMarket" => 208.3
//] // app/Http/Services/PolygonIoService.php:66

        $result = [
            'info' => [],
            'ticker' => $ticker,
            'refreshed' => $data['from'],
            'items' => [
                $data['from'] => [
                    'open'   => $data['open'] ?? '',
                    'high'   => $data['high'] ?? '',
                    'low'    => $data['low'] ?? '',
                    'close'  => $data['close'] ?? '',
                    'volume' => $data['volume'] ?? '',

                    'afterHours' => $data['afterHours'] ?? '',
                    'preMarket'  => $data['preMarket'] ?? '',
                ],
            ],
        ];

        return $result;
    }
}
