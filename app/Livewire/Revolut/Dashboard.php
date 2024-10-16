<?php

namespace App\Livewire\Revolut;

use App\Http\Controllers\Revolut\DashboardController;
use App\Models\Revolut\Commodities\CommoditiesTransaction;
use App\Models\Revolut\Crypto\CryptoTransaction;
use App\Models\Revolut\CurrencyExchanges;
use App\Models\Revolut\Money\CashTransaction as MoneyCashTransaction;
use App\Models\Revolut\Stock\StockPrices;
use App\Models\Revolut\Stock\StockRoboTransaction;
use App\Models\Revolut\Stock\StockTransaction;
use Carbon\Carbon;

class Dashboard extends AbstractComponent
{
    public static function getLatestUpdate()
    {
        $models = [
            'currency' => CurrencyExchanges::class,
            'stock prices' => StockPrices::class,
            'stock' => StockTransaction::class,
            'stock robo' => StockRoboTransaction::class,
            'crypto' => CryptoTransaction::class,
            'commodity' => CommoditiesTransaction::class,
            'money' => MoneyCashTransaction::class,
        ];

        $results = [];
        foreach ($models as $key => $model) {
            $item = $model::latest()->first()?->toArray();
            $when = $item['created_at'] ?? null;
            if (null === $when) {
                continue;
            }

            $results[$key] = Carbon::parse($when)->format('Y-m-d H:i:s');
        }

        return $results;
    }

    public static function getRevolutSummary()
    {
        $items = [];

        $dashboardController = new DashboardController();

        $today = Carbon::today()->format('Y-m-d');
        $models = $dashboardController::getModels();
        if (count($models) > 0) {
            $items = $dashboardController::setModelInfo($models);
        }
        $user = auth()->user()->toArray();
        $user['sessionTime'] = session()->get('last_login_at')?->toArray()['formatted'];

        $results = [
            'today' => $today,
            'user'  => $user,
            'items' => $items,
            'stats' => $dashboardController::getInfoStockTransactions(),
            'info'  => self::getLatestUpdate(),
        ];

        return $results;
    }
}
