<?php

use Illuminate\Support\Number;
use Illuminate\Support\Carbon;

if (!function_exists('dateFormatISO')) {
    function dateISO8601(string $value = null, string $format = 'Y-m-d'): string
    {
        if(null === $value) {
            return date($format);
        }

        $carbonDate = Carbon::parse($value);
        $formattedDate = $carbonDate->format($format) ?? '';

        return $formattedDate;
    }
}

if (!function_exists('numberFormat')) {
    function numberFormat($number, $decimals = 2, $decimalPoint = '.', $thousandSeparator = ' ')
    {
        return number_format($number ?? 0, $decimals, $decimalPoint, $thousandSeparator);
    }
}

if (!function_exists('currencyFormat')) {
    function currencyFormat($value, $currency = 'EUR', $locale = 'pl')
    {
        return Number::currency($value, $currency, $locale);
    }
}

if (!function_exists('shorted')) {
    function shorted(string $value, $maxLength = 20)
    {
        return Str::limit($value, $maxLength);
    }
}


// composer:
//"autoload": {
//    "files": [
//        "app/Helpers/helpers.php"
//    ]
//}
