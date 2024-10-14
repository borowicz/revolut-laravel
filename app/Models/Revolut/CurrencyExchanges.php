<?php

namespace App\Models\Revolut;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class CurrencyExchanges extends AbstractRevolutModel
{
    protected $fillable = [
        'source',
        'hash',
        'date',
        'currency',
        'code',
        'exchange_rate',
    ];

    public static function getExchangeRateToday()
    {
        return (new self())->query()
            ->select('exchange_rate as today')
            ->where('code', '=', 'USDEUR')
            ->orderBy('date', 'desc');
    }

    public function getExchangeCurrenciesToday()
    {
        $tableName = $this->getTable();
        $rawQuery = 'SELECT code, MAX(date) as max_date FROM ' . $tableName . ' GROUP BY code';

        $query = $this->select('currency_exchanges.*')
            ->join(
                DB::raw('(' .$rawQuery . ') as latest'),
                function($join) use ($tableName) {
                    $join->on($tableName . '.code', '=', 'latest.code')
                        ->on($tableName . '.date', '=', 'latest.max_date');
                }
            )
            ->orderBy('currency');

        return $query;
    }

    public function getExchangeCurrencies()
    {
        $results = $this->select('currency', 'code')
            ->distinct('code')
            ->orderBy('code');

        return $results;
    }
}
