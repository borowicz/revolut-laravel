<?php

namespace App\Livewire\Revolut\Stock\Summary;

use DateTime;
use App\Models\Revolut\Stock\{
    CashCurrent,
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
    const TYPE_TOP_UP     = 'top up';
    const TYPE_DIVIDEND   = 'dividend';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPE_FEE        = 'fee';

    protected $latestStockPrices = [];
    protected $disabledTickers = null;
    protected $showAll = false;
    protected $tickers = [];
    protected $totalValue = 0;
    public $data = [];

    protected function setResults(): array
    {
        return [
            'summary' => [
                'total' => 0, 'spent' => 0, 'return' => 0, 'dividend' => 0,
                'feesTotal' => 0, 'cashTotal' => 0, 'cash' => [], 'fees' => [], 'prices' => []
            ],
            'latest' => [], 'stocks' => []
        ];
    }

    protected function setValue(string $v = ''): int
    {
        return empty($v) ? 0 : (int)$v;
    }

    public function determineTransactionType(string $type): string
    {
        foreach ([self::TYPE_CASH, self::TYPE_DIVIDEND, self::TYPE_SPLIT, self::TYPE_BUY, self::TYPE_SELL] as $transactionType) {
            if (stristr($type, $transactionType)) return $transactionType;
        }
        return 'other';
    }

    public function checkIfTickerDisabled(string $ticker): bool
    {
        if ($this->disabledTickers === null) {
            $this->disabledTickers = StockPrices::getTickersDisabled() ?? [];
        }
        return in_array($ticker, $this->disabledTickers);
    }

    public function getData(bool $showAll = false, array $tickers = []): array
    {
        $this->showAll = $showAll;
        $this->latestStockPrices = StockPrices::getLatestStockPricesList();
        $transactions = $this->processTransactions($tickers);
        if (!isset($transactions['stocks'])) return ['stocks' => []];

        $this->data = $transactions;
        $this->data['stocks'] = $this->recalculateTransactions($this->data['stocks']) ?? [];
        $this->data['totalCash'] = StockTransaction::getTransactionsCash();
        $this->data['totalMoney'] = CashCurrent::select('total')->latest('id')->value('total') ?? 0;
        $this->data['totalValue'] = $this->totalValue;
        $this->data['showButtons'] = true;
        $this->data['showAll'] = $this->showAll;
        $this->data['tickers'] = $this->tickers ?? [];

        return $this->data;
    }

    protected function processTransactions(array $tickers = []): array
    {
        $query = StockTransaction::orderBy('ticker', 'ASC')->orderBy('date', 'ASC');
        if (count($tickers)) $query->whereIn('ticker', $tickers);
        return $this->initializeResults($query->get());
    }

    protected function initializeResults($transactions): array
    {
        $this->data = $this->setResults();
        $this->data['latest'] = $this->latestStockPrices ?? [];
        foreach ($transactions as $transaction) {
            if (empty($transaction['ticker']) || $this->checkIfTickerDisabled($transaction['ticker'])) continue;
            $this->processTransaction($transaction, (new DateTime($transaction->date))->format('Y'));
        }
        return $this->data;
    }

    protected function processTransaction($transaction, $currentYear): void
    {
        $ticker = $transaction->ticker;
        if (!isset($this->data['stocks'][$ticker])) $this->data['stocks'][$ticker] = $this->initializeStockItem($ticker);
        if (!isset($this->data['yearly']['byStock'][$ticker])) $this->data['yearly']['byStock'][$ticker] = $this->initializeStockItem($ticker);
        if (!isset($this->data['yearly']['byYear'][$currentYear])) $this->data['yearly']['byYear'][$currentYear] = $this->initializeStockItem($ticker);

        $type = $this->determineTransactionType($transaction->type);
        if ($type == self::TYPE_CASH) {
            $this->handleCashTransaction($transaction, $currentYear);
            return;
        }
        if (empty($ticker)) {
            $this->handleOtherTransactions($transaction);
            return;
        }
        if (!in_array($ticker, $this->tickers)) $this->tickers[] = $ticker;

        $item = ['currentYear' => $currentYear, 'type' => $type, 'ticker' => $ticker, 'transaction' => $transaction];
        $this->updateTransactionData($this->data['stocks'][$ticker], $this->data['yearly'], $this->data['summary'], $item);
    }

    protected function handleCashTransaction($transaction, $currentYear): void
    {
        $this->data['summary']['cash'][] = $transaction;
        $this->data['summary']['cashTotal'] += $transaction->total;
        $this->data['yearly']['byYear'][$currentYear]['cashTotal'] += $transaction->total;
    }

    protected function handleOtherTransactions($transaction): void
    {
        $this->data['summary']['other'][] = $transaction;
    }

    protected function initializeStockItem($ticker): array
    {
        return [
            'ticker' => $ticker, 'quantity' => 0, 'total' => 0, 'spent' => 0, 'return' => 0,
            'dividend' => 0, 'feesTotal' => 0, 'cashTotal' => 0, 'prices' => [], 'yearly' => [], 'fees' => []
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
        $fee = $total - round($quantity * $price, 2);

        $stock['prices'][] = [$item['transaction']->date, $price];
        $stock['fees'][] = $fee;
        $stock['feesTotal'] += $fee;
        $summary['feesTotal'] += $fee;

        if ($type === self::TYPE_BUY) {
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

            if ($item['quantity'] <= 0) continue;

            $item['avgBuy'] = $item['quantity'] > 0 ? $item['total'] / $item['quantity'] : 0;
            if ($item['spent'] > 0) $item['avgBuy'] *= -1;
            $item['diff'] = $item['return'] - $item['spent'];
            $item['latestDate'] = '';

            if (isset($this->latestStockPrices[$ticker])) {
                $item['current'] = $this->latestStockPrices[$ticker]['close'];
                $item['latestDate'] = date('Y-m-d', strtotime($this->latestStockPrices[$ticker]['day']));
                if ($item['quantity'] > 0) $item['avgCurrent'] = $item['current'];
            }

            if ($item['avgBuy'] > 0 && $item['avgCurrent'] < $item['avgBuy']) $item['avgCurrentAlert'] = true;
            $item['currentValue'] = $item['avgCurrent'] * $item['quantity'];
            $item['currentProfit'] = $item['currentValue'] + $item['diff'];
            $this->totalValue += $item['currentValue'];
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

        if (!$all) $query->where($tickersTable . '.disabled', 0);
        $query->where($tickersTable . '.ticker', '!=', '')->whereNotNull($tickersTable . '.ticker');
        $query->orderBy('ticker');

        return $query;
    }
}
