<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;

class AlphaVantageService extends AbstractApiService implements ApiInterface
{
    protected $apiUrl = 'https://www.alphavantage.co/query';

    protected $sleepDelay = 2; // second delay

    public function setApiKeyUrl(): void
    {
        $this->apiKey = config('revolut.api.alphavantage');
        if (empty($this->apiKey)) {
            $this->apiUrl = config('revolut.api.alphavantageUrl');
        }
    }

    public function fetchApi(string $ticker, string $when, bool $force = false): array
    {
        // replace the "demo" apikey below with your own key from https://www.alphavantage.co/support/#api-key
        // https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=IBM&apikey=demo
        try {
            // Send a GET request with query parameters
            $response = $this->client->request('GET', $this->apiUrl, [
                'function' => 'TIME_SERIES_DAILY',
                //            'function' => 'GLOBAL_QUOTE',
                //            'function'   => 'TIME_SERIES_INTRADAY',
                //            'interval'   => '5min',
                //            'outputsize' => 'compact',
                'symbol' => $ticker,
                'apikey' => $this->apiKey,
            ]);
        } catch (\Exception $e) {
            Log::warning($this->apiName . ' - ' . $e->getMessage());

            throw new \Exception($e->getMessage());
        }

        if ($response || 200 !== $statusCode = $response?->getStatusCode()) {
            Log::warning($this->apiName . ' - ' . $statusCode);
        }

        $body = $response->getBody();
        $result = json_decode($body, true);
        $result = $this->setItem($result, $ticker);
        $this->storeLocalJson($result);
        if ($this->sleepDelay) {
            sleep($this->sleepDelay);
        }

        return $result;
    }

    public function setItem(array $data, string $ticker): array
    {
        if (!empty($info = $result['information'] ?? '')) {
            if (stristr($info, 'limit')) {
                throw new \Exception('API limit exceeded');

                return [];
            }
        }

        $info = array_slice($result, 0, 1);
        $info = reset($info);
        if (!is_array($info)) {
            throw new \Exception('no dats: ' . $ticker . ' != ' . $info);

            return [];
        }

        $info = array_values($info);
        if ($ticker != ($info[1] ?? '')) {
            throw new \Exception('Invalid ticker: ' . $ticker . ' != ' . $info[1]);

            return [];
        }

        $refreshed = $info[2];

        $items = array_slice($result, 1, 1);
        $items = reset($items);

        $result = [
            'info'      => $info,
            'ticker'    => $ticker,
            'refreshed' => $refreshed,
            'items'     => $items
        ];

        return $result;
    }
}
