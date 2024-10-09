<?php

namespace App\Livewire\Revolut\Stock\Summary;

use DateTime;
use App\Models\Revolut\Stock\{
    StockTransaction,
    StockTicker,
    StockPrices,
};

class StockCalculations
{
    const TYPE_BUY        = 'buy';
    const TYPE_SELL       = 'sell';
    const TYPE_SPLIT      = 'split';
    const TYPE_CASH       = 'cash';
    const TYPE_DIVIDEND   = 'dividend';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_FEE        = 'fee'; // CUSTODY FEE

    protected $latestStockPrices = [];
    protected $disabledTickers = null;
    protected $showAll = false;
    protected $tickers = [];

    protected function setResults(): array
    {
        return [
            'summary' => [
                'total'     => 0,
                'spent'     => 0,
                'return'    => 0,
                'dividend'  => 0,
                'feesTotal' => 0,
                'cashTotal' => 0,
                'cash'      => [],
                'fees'      => [],
                'prices'    => [],
            ],
            'latest'  => [],
            'stocks'  => [],
        ];
    }

    protected function setValue(string $v = '')
    {
        if (empty($v)) {
            return 0;
        }

        $result = $v;
//        $result = numberFormat($result, 2, '.', '');
//        $result = (float)$result;

        return $result;
    }

    public function determineTransactionType(string $type): string
    {
        $type = strtolower($type);
        $type = trim($type);

        if (stristr($type, self::TYPE_CASH)) {
            return self::TYPE_CASH;
        }

        if (stristr($type, self::TYPE_DIVIDEND)) {
            return self::TYPE_DIVIDEND;
        }

        if (stristr($type, self::TYPE_SPLIT)) {
            return self::TYPE_SPLIT;
        }

        if (stristr($type, self::TYPE_BUY)) {
            return self::TYPE_BUY;
        }

        if (stristr($type, self::TYPE_SELL)) {
            return self::TYPE_SELL;
        }

        return 'other';
    }

    public function checkIfTickerDisabled(string $ticker): bool
    {
        if (null === $this->disabledTickers) {
            $results = StockPrices::getTickersDisabled() ?? [];
            $this->disabledTickers = $results;
        }

        if (0 === count($this->disabledTickers)) {
            return false;
        }

        if (in_array($ticker, $this->disabledTickers)) {
            return true;
        }

        return false;
    }

    public function getData(bool $showAll = false, array $tickers = [])
    {
        $this->showAll = $showAll;
        $this->latestStockPrices = StockPrices::getLatestStockPricesList();

        $transactions = $this->processTransactions($tickers);
        if (!isset($transactions['stocks'])) {
            return ['stocks' => []];
        }

        if (!$transactions['stocks']) {
            $results = $this->setResults();
//            throw new \Exception('No transactions found');
        } else {
            $results = $transactions;
        }

        $results['stocks'] = $this->recalculateTransactions($results['stocks']) ?? [];
        $results['showButtons'] = true;
        $results['showAll'] = $this->showAll;
        $results['tickers'] = $this->tickers ?? [];

        return $results;
    }

    protected function processTransactions(array $tickers = []): array
    {
        $query = StockTransaction::orderBy('ticker', 'ASC')->orderBy('date', 'ASC');
        if (count($tickers)) {
            $query->whereIn('ticker', $tickers);
        }

        $transactions = $query->get();

        if (!count($transactions)) {
            return [];
        }

        return $this->initializeResults($transactions);
    }

    protected function initializeResults($transactions)
    {
        $results = $this->setResults();
        $results['latest'] = $this->latestStockPrices ?? [];

        $previousYear = 0;

        foreach ($transactions as $transaction) {
            if (empty($transaction['ticker']) || $this->checkIfTickerDisabled($transaction['ticker'])) {
                continue;
            }

            $dateTime = new DateTime($transaction->date);
            $currentYear = $dateTime->format('Y');
            if ($previousYear === 0) {
                $previousYear = $currentYear;
            }

            $this->processTransaction($results, $transaction, $currentYear, $previousYear);
//            if ($previousYear !== $currentYear) {
//            }

            $previousYear = $currentYear;
        }

        return $results;
    }


    protected function processTransaction(&$results, $transaction, $currentYear, $previousYear): void
    {
        $ticker = $transaction->ticker;

        if (!isset($results['stocks'][$ticker])) {
            $results['stocks'][$ticker] = $this->initializeStockItem($ticker);
        }

        if (!isset($results['yearly']['byStock'][$ticker])) {
            $results['yearly']['byStock'][$ticker] = $this->initializeStockItem($ticker);
            unset (
                $results['yearly']['byYear'][$currentYear]['ticker'],
                $results['yearly']['byYear'][$currentYear]['quantity'],
            );
        }

        if (!isset($results['yearly']['byYear'][$currentYear])) {
            $results['yearly']['byYear'][$currentYear] = $this->initializeStockItem($ticker);
            unset (
                $results['yearly']['byYear'][$currentYear]['ticker'],
                $results['yearly']['byYear'][$currentYear]['quantity'],
            );
        }

        $type = $this->determineTransactionType($transaction->type);

        if ($type == self::TYPE_CASH) {
            $this->handleCashTransaction($results, $transaction, $currentYear);

            return;
        }

        if (empty($ticker)) {
            $this->handleOtherTransactions($results, $transaction);

            return;
        }

        if (!in_array($ticker, $this->tickers)) {
            $this->tickers[] = $ticker;
        }

        $item = [
            'previousYear' => $previousYear,
            'currentYear'  => $currentYear,
            'type'         => $type,
            'ticker'       => $ticker,
            'transaction'  => $transaction,
        ];

        $this->updateTransactionData(
            $results['stocks'][$ticker],
            $results['yearly'],
            $results['summary'],
            $item
        );
    }

    protected function handleCashTransaction(&$results, $transaction, $currentYear): void
    {
        $results['summary']['cash'][] = $transaction;
        $results['summary']['cashTotal'] += $transaction->total;

        $results['yearly']['byYear'][$currentYear]['cashTotal'] += $transaction->total;
    }

    protected function handleOtherTransactions(&$results, $transaction): void
    {
        $results['summary']['other'][] = $transaction;
    }

    protected function initializeStockItem($ticker): array
    {
        return [
            'ticker'    => $ticker,
            'quantity'  => 0,
            'total'     => 0,
            'spent'     => 0,
            'return'    => 0,
            'dividend'  => 0,
            'feesTotal' => 0,
            'cashTotal' => 0,
            'prices'    => [],
            'yearly'    => [],
            'fees'      => [],
        ];
    }


    protected function updateTransactionData(array &$stock, array &$yearly, array &$summary, array $item): void
    {
        $type = $item['type'];
        $ticker = $item['ticker'];
        $currentYear = $item['currentYear'];

        $quantity = $this->setValue($item['transaction']->quantity);
        $price = $this->setValue($item['transaction']->price_per_share);
        $total = $this->setValue($item['transaction']->total_amount);
        $fee = 0;

        if ($price > 0) {
            $stock['prices'][] = [$item['transaction']->date, $price];
            $fee = $total - round($quantity * $price, 2);

            $stock['fees'][] = $fee;
            $stock['feesTotal'] += $fee;
            $summary['feesTotal'] += $fee;
        }

        if ($item['type'] === self::TYPE_BUY) {
            $stock['quantity'] += $quantity;
            $stock['total'] -= $total;
            $stock['spent'] += $total;

            $yearly['byStock'][$ticker]['total'] -= $total;
            $yearly['byStock'][$ticker]['spent'] += $total;

            $yearly['byYear'][$currentYear]['total'] -= $total;
            $yearly['byYear'][$currentYear]['spent'] += $total;

            $summary['total'] -= $total;
            $summary['spent'] += $total;
        } elseif ($type === self::TYPE_SELL) {
            $stock['quantity'] -= $quantity;
            $stock['total'] += $total;
            $stock['return'] += $total;

            $yearly['byStock'][$ticker]['total'] += $total;
            $yearly['byStock'][$ticker]['return'] += $total;

            $summary['total'] += $total;
            $summary['return'] += $total;
        } elseif ($type === self::TYPE_DIVIDEND) {
            $stock['total'] += $total;
            $stock['return'] += $total;
            $stock['dividend'] += $total;

            $yearly['byStock'][$ticker]['dividend'] += $total;

            $yearly['byYear'][$currentYear]['dividend'] += $total;

            $summary['dividend'] += $total;
        } elseif ($type === self::TYPE_SPLIT) {
            $stock['quantity'] += $quantity;
        }

//        $results['yearly'][$ticker][$currentYear]['profit_loss'] =
//            $results['yearly'][$ticker][$currentYear]['return'] - $results['yearly'][$ticker][$currentYear]['spent'];
    }

    protected function recalculateTransactions(array $stock): array
    {
        foreach ($stock as $ticker => &$item) {
            $item['latestPrice'] = 0;
            $item['diff'] = 0;
            $item['avgBuy'] = 0;
            $item['currentValue'] = 0;
            $item['currentProfit'] = 0;
            $item['avgCurrent'] = 0;
            $item['avgCurrentAlert'] = false;

            if ($item['quantity'] <= 0) {
                continue;
            }

            if ($item['quantity'] > 0) {
                if ($item['quantity'] > 1) {
                    $item['avgBuy'] = $item['total'] / $item['quantity'];
                } else {
                    $item['avgBuy'] = $item['total'] * $item['quantity'];
                }
            } else {
                $item['avgBuy'] = 0;
            }

            if ($item['spent'] > 0) {
                $item['avgBuy'] = $item['avgBuy'] * -1;
            }

            // Calculate diff as net return - total spent
            $item['diff'] = $item['return'] - $item['spent'];

            $item['latestDate'] = '';
            if (isset($this->latestStockPrices[$ticker])) {
                $item['current'] = $this->latestStockPrices[$ticker]['close'];
                $item['latestDate'] = date(
                    'Y-m-d',
                    strtotime($this->latestStockPrices[$ticker]['day'])
                );

                if ($item['quantity'] > 0) {
                    if ($item['quantity'] < 1) {
                        $avgCurrent = ($item['current'] * $item['quantity']);
                    } else {
                        $avgCurrent = ($item['current'] * $item['quantity']) / $item['quantity'];
                    }

                    $item['avgCurrent'] = $avgCurrent;
                }
            }

            // Check if the current average price is less than the buying average price
            if ($item['avgBuy'] > 0 && $item['avgCurrent'] < $item['avgBuy']) {
                $item['avgCurrentAlert'] = true;
            }

            // Calculate current value and profit
            $item['currentValue'] = $item['avgCurrent'] * $item['quantity'];
            $item['currentProfit'] = $item['currentValue'] + $item['diff'];
        }

        return $stock;
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

        $tickers = $query->get()
            ->pluck('ticker')
            ->toArray();

        return $tickers;
    }
}
