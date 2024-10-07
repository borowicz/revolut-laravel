<?php

return [
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),

    'source' => env('APP_SOURCE_URL', ''),

    'api' => [
        'alphavantage'    => env('API_KEY_ALPHAVANTAGE'),
        'alphavantageUrl' => env('API_URL_ALPHAVANTAGE', 'https://www.alphavantage.co/query'),

        'polygonio'       => env('API_KEY_POLYGONIO'),
        'polygonioUrl'    => env('API_URL_POLYGONIO', 'https://api.polygon.io/v1/open-close/'),

        'finhubio'        => env('API_KEY_FINHUBIO'),
        'finhubioUrl'     => env('API_URL_FINHUBIO', 'ttps://finnhub.io/api/v1/quote'),

        'nasdaq'          => env('API_KEY_NASDAQ'),
        'nasdaqUrl'       => env('API_URL_NASDAQ', 'https://api.nasdaq.com/api/quote/'),

        'googleSheet'     => env('API_KEY_GOOGLE_SHEET'),
    ],

    'currency' => [
        'apiGDrive'    => env('CURRENCY_API_GDRIVE'),
        'gDrive'       => env('CURRENCY_GDRIVE'),
        'gDriveCsvUrl' => env('CURRENCY_GDRIVE_CSV_URL'),
    ],
];
