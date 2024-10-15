<?php

namespace App\Helpers;

class NumberHelper
{
    public static function formatNumber($number, $decimals = 2, $decimalPoint = '.', $thousandSeparator = ',')
    {
        return number_format($number, $decimals, $decimalPoint, $thousandSeparator);
    }
}

// composer json:
//"autoload": {
//    "files": [
//        "app/Helpers/NumberHelper.php"
//    ]
//}

// blade
// {{ \App\Helpers\NumberHelper::formatNumber(12345.6789) }}
