<?php

return [
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),

    'source' => env('APP_SOURCE_URL', ''),

    'apiKey' => [
        'alphavantage' => env('API_KEY_ALPHAVANTAGE'),
        'polygonio'    => env('API_KEY_POLYGONIO'),
        'finhubio'     => env('API_KEY_FINHUBIO'),
        'nasdaq'       => env('API_KEY_NASDAQ'),

        'googleSheet' => env('API_KEY_GOOGLE_SHEET'),
    ],

    'currency' => [
        'apiGDrive'    => env('CURRENCY_API_GDRIVE'),
        'gDrive'       => env('CURRENCY_GDRIVE'),
        'gDriveCsvUrl' => env('CURRENCY_GDRIVE_CSV_URL'),
    ],
];
