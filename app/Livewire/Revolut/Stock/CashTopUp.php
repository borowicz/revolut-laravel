<?php

namespace App\Livewire\Revolut\Stock;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
use App\Models\Revolut\Stock\StockTransaction;
use App\Models\Revolut\CurrencyExchanges;
use App\Livewire\Revolut\AbstractComponent;

class CashTopUp extends AbstractComponent
{
    use WithPagination;

    public $perPage = 30; // Number of items per page

    public function render(Request $request)
    {
        debugbar()->info('$this->perPage: ' . $this->perPage);

        $model = new StockTransaction();

        $total = $model::getTransactionsCash($model);
        $query = $model->getCashTopUp();
        $query->orderBy($this->sortField, $this->sortDirection);
        $calculated = $this->calculate($query);
        $items = $this->setPagination($query);
        $hasPages = $this->hasPagination($items);

        return view('livewire.revolut.stock.cash-top-up', [
            'items'      => $items,
            'total'      => $total,
            'calculated' => $calculated,
            'hasPages'   => $hasPages,
        ])->layout('layouts.app');
    }

    private function calculate($query): array
    {
        $results = [
            'byYear' => [],
            'yearly' => [],
            'transactions' => [],
            'total' => 0,
            'totalExchangeRate' => 0,
//            'currentExchangeRate' => 0,
        ];
        $data = $query->get()->toArray();

        foreach ($data as $value) {
            $current = [];
            $current['when'] = $value['date'];

            $year = Carbon::parse($value['date'])->format('Y');
            if (!isset($results['byYear'][$year])) {
                $results['byYear'][$year]['total'] = 0;
                $results['byYear'][$year]['exchange'] = 0;
            }

            $current['code'] = $value['code'];
            $current['currency'] = $value['currency'];
            $current['value'] = $value['total_amount'];
            if (stristr($value['type'], StockCalculations::TYPE_WITHDRAWAL)) {
                $current['value'] = -1 * $current['value'];
            }
            $exchangeRate = $current['value'] * $value['exchange_rate'];
            if($exchangeRate > 0) {
                $current['exchange_rate'] = numberFormat($exchangeRate);
                $results['total'] += $value['total_amount'];
                $results['totalExchangeRate'] += $exchangeRate;

                $results['byYear'][$year]['total'] += $value['total_amount'];
                $results['byYear'][$year]['exchange'] += $exchangeRate;

                $results['yearly'][$year][$value['hash']] = $current;
                $results['transactions'][$value['hash']] = $current;
            }
        }

        $latestExchangeRate = CurrencyExchanges::getExchangeRateToday()->first()?->toArray();

        $latestExchangeRate = $latestExchangeRate['today'] ?? 0;
        $results['currentExchangeRate'] = $latestExchangeRate * $results['total'];

        return $results;
    }
}
