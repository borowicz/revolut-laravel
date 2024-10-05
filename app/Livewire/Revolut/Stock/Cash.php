<?php

namespace App\Livewire\Revolut\Stock;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Livewire\Revolut\Stock\Summary\StockCalculations;
//use App\Livewire\Revolut\Stock\Summary\CalculatedDetails;
use App\Models\Revolut\Stock\StockTransaction;
use App\Models\Revolut\CurrencyExchanges;
use App\Models\Revolut\Stock\StockPrices;
use App\Models\Revolut\Stock\Cash as StockCash;
use App\Livewire\Revolut\AbstractComponent;

class Cash extends AbstractComponent
{
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render(Request $request)
    {
//        $current = [];

        $query = StockTransaction::getCashTopUp();
        $query->orderBy($this->sortField, $this->sortDirection);

        $calculated = $this->calculate($query);
//dd($this->perPage);
        $items = $this->setPagination($query);
//        if ((int)$this->perPage > 0) {
        $hasPages = $this->hasPagination($items);
//dd($hasPages);
//        } else {
//        }
//dd($items);

        $this->showButtons = false;
        $this->tickers = null;

        debugbar()->info('$this->perPage: ' . $this->perPage);
//        debugbar()->info('$this->perPage: ' . $this->showButtons);
//        debugbar()->info('$hasPages: ' . $hasPages);

        return view('livewire.revolut.stock.cash', [
            'items'      => $items,
            'calculated' => $calculated,
            'hasPages' => $hasPages,
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
//dd($data);
//"id" => 1353
//"hash" => "6780d23b3b20b69917a6f0a8f902d93690954a06"
//"date" => "2024-09-16 10:50:33"
//"ticker" => ""
//"type" => "CASH TOP-UP"
//"quantity" => "0.000000"
//"price_per_share" => "0.000000"
//"total_amount" => "300.000000"
//"currency" => "USD"
//"fx_rate" => "0.260900"
//"created_at" => "2024-10-05T14:52:54.000000Z"
//"updated_at" => "2024-10-05T14:52:54.000000Z"
//"deleted_at" => null
//"source" => "googleSheet"
//"when" => "2024-09-16"
//"code" => "USDEUR"
//"exchange_rate" => "0.898510"

        foreach ($data as $value) {
            $current = [];
            $current['when'] = $value['date'];

            $year = Carbon::parse($value['when'])->format('Y');
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

        $latestExchangeRate = CurrencyExchanges::query()
            ->select('exchange_rate as today')
            ->where('code', '=', 'USDEUR')
            ->orderBy('when', 'desc')
            ->first()
            ->toArray();

        $latestExchangeRate = $latestExchangeRate['today'] ?? 0;
        $results['currentExchangeRate'] = $latestExchangeRate * $results['total'];

        return $results;
    }
}
