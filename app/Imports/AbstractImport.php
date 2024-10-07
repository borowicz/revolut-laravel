<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Session;

abstract class AbstractImport implements ToModel
{
    public $model;

    public $importStats = [];

    public function setModel(string $model)
    {
        if (null === $this->model) {
            $this->model = new $model();
        }

        return $this->model;
    }

    public static function setStats()
    {
        $importStats = [
            'total'    => 0,
            'inserted' => 0,
            'skipped'  => 0,
        ];

        Session::put('importStats', $importStats);
    }

    protected function setNumber(string $value, int $decimal = 6): string
    {
        $value = $this->cleanValue($value);
        $value = (float)$value;

//        return number_format($value, $decimal, '.', '');
        return numberFormat($value, $decimal, '.', '');
    }

    protected function getCurrency(string $string): string
    {
        $currencySymbol = '';

        preg_match('/([€£$])([\d,]+\.\d{2})/', $string, $matches);

        if (!empty($matches)) {
            $currencySymbol = $matches[1];
//            $amount = $matches[2];
//            echo "Currency: " . $currencySymbol . "\n";
//            echo "Amount: " . $amount . "\n";
        }
//        else {
////            echo "No currency found.";
//        }

        return $currencySymbol;
    }
    protected function cleanValue(string $value): string
    {
        $result = $value;

//        $result = str_replace('$', '', $result);
//        $result = str_replace('€', '', $result);

        $result = preg_replace('/[^0-9\.\,]/', '', $result);
        $result = str_replace([',', ' '], '', $result);

        // Replace the decimal comma with a period
        $result = str_replace(',', '.', $result);

        // Convert the cleaned string to a number
//        $result = (float) $result;

        return $result;
    }
}
