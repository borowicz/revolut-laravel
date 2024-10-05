<?php

namespace App\Http\Services;

class PolygonIoService extends AbstractApiService
{
    public function getStockPriceData(string $ticker, string $when, bool $force = false): array
    {
        $results = parent::getStockPriceData($ticker, $when, $force);
        if (!$results) {
            // polygon.io/docs/stocks/get_v1_open-close__stocksticker___date
            $queryParams = [
                'adjusted' => 'true',
                'apikey'   => $this->apiKey,
            ];


            $results = $this->fetchApi($ticker, $when);
        }

        return $results;
    }
}
