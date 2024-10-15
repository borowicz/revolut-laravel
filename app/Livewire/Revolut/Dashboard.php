<?php

namespace App\Livewire\Revolut;

use Carbon\Carbon;
use App\Http\Controllers\Revolut\DashboardController;

class Dashboard extends AbstractComponent
{
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
        ];

        return $results;
    }
}
