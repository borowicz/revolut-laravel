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

        return number_format($value, $decimal, '.', '');
    }

    protected function cleanValue(string $value): string
    {
        $result = $value;

        $result = str_replace(' ', '', $result);
        $result = str_replace('$', '', $result);
        $result = str_replace('€', '', $result);

        $result = trim(str_replace(',', '', $result));

        return $result;
    }
}
