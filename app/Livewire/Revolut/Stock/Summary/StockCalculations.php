<?php

namespace App\Livewire\Revolut\Stock\Summary;

use DateTime;
use App\Models\Revolut\StockTransaction;
use App\Models\Revolut\StockTicker;
use App\Models\Revolut\StockPrices;

class StockCalculations
{
    const TYPE_BUY      = 'buy';
    const TYPE_SELL     = 'sell';
    const TYPE_SPLIT    = 'split';
    const TYPE_CASH     = 'cash';
    const TYPE_DIVIDEND = 'dividend';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_FEE      = 'fee'; // CUSTODY FEE

    public function getData(array $tickers = [], bool $showAll = false)
    {
        debugbar()->notice('showAll: ' . $showAll);

        $results = [];
        $results['tickers'] = $this->getTickersList();
        $results['stocks'] = ['AAPL' => ['avgBuy' => 12], 'APL' => ['avgSell' => 12]];

        return $results;
    }

    public function getTickersList(bool $all = false)
    {
        $tickersTable = (new StockTicker())->getTable();
        $stockTransactions = (new StockTransaction())->getTable();

        $query = StockTransaction::query()
            ->select($stockTransactions . '.ticker')
            ->distinct()
            ->leftJoin($tickersTable, $tickersTable . '.ticker', $stockTransactions . '.ticker');

        if (false === $all) {
            $query->where($tickersTable . '.disabled', 0);
        }
        $query->orderBy('ticker');
//dd($query->toSql());
        $tickers = $query->get()
            ->pluck('ticker')
            ->toArray();
//dd($tickers);
        return $tickers;
    }
}
