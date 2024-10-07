<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class PolygonIoService extends AbstractApiService implements ApiInterface
{
    protected $apiUrl = 'https://api.polygon.io/v1/open-close/';
    protected $sleepDelay = 15; // second delay between request, free tier: 5 requests per minute

    public function setApiKeyUrl(): void
    {
        $this->apiKey = config('revolut.api.polygonio');
        if (empty($this->apiKey)) {
            $this->apiUrl = config('revolut.api.polygonioUrl');
        }
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
            $response = $this->client->request('GET', $apiUrl, ['query' => $queryParams]);
        } catch (\Exception $e) {
            Log::warning($this->apiName . ' - ' . $e->getMessage());

            throw new \Exception($e->getMessage());
        }

        $statusCode = $response?->getStatusCode();
        if ($response || 200 !== $statusCode) {
            Log::warning($this->apiName . ' - ' . $statusCode);

            return [];
        }

        $body = $response->getBody();
        $data = json_decode($body, true);

        if($ticker !== $data['symbol']) {
            $msg = 'Invalid ticker: ' . $ticker . ' != ' . $data['symbol'];
            throw new \Exception($msg);
        }

        $result = $this->setItem($data, $ticker);
        $this->storeLocalJson($result);
        if ($this->sleepDelay) {
            sleep($this->sleepDelay);
        }

        return $result;
    }

    public function setItem(array $data, string $ticker): array
    {
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
