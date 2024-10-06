<?php

namespace App\Livewire\Revolut;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dashboard extends AbstractComponent
{
    public static function getRevolutSummary()
    {
        $items = [];

        $today = Carbon::today()->format('Y-m-d');
        $models = self::getModels();
        if (count($models) > 0) {
            $items = self::setModelInfo($models);
        }
        $user = auth()->user()->toArray();
        $user['sessionTime'] = session()->get('last_login_at')?->toArray()['formatted'];
debugbar()->info($items);
        return ['today' => $today, 'user' => $user, 'items' => $items,];
    }

    public static function getModels(): array
    {
        $modelsPath = app_path('Models/Revolut');
        $files = File::allFiles($modelsPath);
        if (!$files) {
            return [];
        }

        return self::setModelList($files);
    }

    public static function setModelList(array $modelsFiles): array
    {
        $results = [];
        $appPath = app_path();

        foreach ($modelsFiles as $file) {
            if ($file->getExtension() !== 'php'
                || Str::contains($file->getFilename(), 'Abstract', true)
            ) {
                continue;
            }

            $modelNameSpace = Str::replace(
                ['.php', $appPath, '/'],
                ['', '', '\\'],
                $file->getPathname()
            );
            $modelNameSpace = 'App' . $modelNameSpace;
            if (class_exists($modelNameSpace)) {
                $results[$modelNameSpace] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
//                $results[$modelNameSpace]['name'] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
//                $results[$modelNameSpace]['model'] = $modelNameSpace;

//                $current[] = self::getModelInfo($modelNameSpace);
//                $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
//                $current['name'] = $name;
//
//                if ($name === 'StockTransaction') {
//                    $current['stats'] = self::getModelInfoStockTransactions($modelNameSpace);
//
//                    $models = array_merge($current, $results);
//                } else {
//                    $results[$modelNameSpace] = $current;
//                }
//
            }
        }
        ksort($results);
//        if (isset($models)) {
//            dd($results);
//        }
        return $results;
    }

    /** @noinspection SlowArrayOperationsInLoopInspection */
    public static function setModelInfo(array $models): array
    {
        $result = [];

        foreach ($models as $model => $name) {
            $current = [];

            $current['model'] = $model;
            $current['name'] = $name;


            try {
                $currentModel = new $model();
            } catch (\Exception $e) {
                $currentModel = null;
            }

            if (null === $currentModel) {
                continue;
            }

            $current['info'] = self::getModelInfo($model);

            if ($name !== 'StockTransaction') {
                $result[$model] = $current;
            } else {
                $current['stats'] = self::getModelInfoStockTransactions($currentModel);

                $result = array_merge([$model => $current], $result);
            }
        }

        return $result;
    }

    public static function getModelInfo(mixed $model): array
    {
        $result['count'] = $model::count();
        if (in_array(SoftDeletes::class, class_uses($model))) {
            $result['total'] = $model::withTrashed()->count();
            $result['deleted'] = $model::onlyTrashed()->count();
        }

        $result['latestUpdatedRecord'] = [];
        $latestUpdatedRecord = $model::select('updated_at', 'created_at')->orderBy('updated_at', 'desc')->first();
        if ($latestUpdatedRecord) {
            $result['latestUpdatedRecord'] = $latestUpdatedRecord->toArray();
        }

        $result['latestUpdateTime'] = $model::max('updated_at');

        return $result;
    }

    public static function getTransactionsTickers(mixed $model): array
    {
        $tickers = $model->select('ticker', \DB::raw('COUNT(id) as count'))
            ->where('ticker', '!=', '')
            ->groupBy('ticker')
            ->orderBy('ticker')
            ->get()
            ->pluck('count', 'ticker')
            ->toArray();
        if (!$tickers) {
            return [];
        }

        $result = [];
        foreach ($tickers as $ticker => $count) {
            $current = 'transactions: '. $count;

            $cash = \DB::table($model->getTable())
                ->select(
                    \DB::raw(
                        '
                    (SUM(CASE WHEN ticker = "' . $ticker . '" AND type LIKE "%sell%" THEN total_amount ELSE 0 END)
                    -
                    SUM(CASE WHEN ticker = "' . $ticker . '" AND type LIKE "%buy%" THEN total_amount ELSE 0 END)) AS total_difference
                '
                    )
                )
                ->value('total_difference');
            $current.= ', cash: ' . numberFormat($cash);

            $result[$ticker] = $current;
        }

        return $result;
    }

    public static function getTransactionsTypes(mixed $model): array
    {
        return $model->select('type', \DB::raw('COUNT(id) as count'))
            ->groupBy('type')
            ->orderBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();
    }

    public static function getTransactionsCash(mixed $model): string
    {
        $cash = \DB::table($model->getTable())
            ->select(
                \DB::raw(
                    '(SUM(CASE WHEN type LIKE "%cash top%" THEN total_amount ELSE 0 END)
                - SUM(CASE WHEN type LIKE "%with%" THEN total_amount ELSE 0 END)) AS total_difference'
                )
            )
            ->value('total_difference');

        return numberFormat($cash);
    }

    public static function getModelInfoStockTransactions(mixed $model): array
    {
        $result = [];
        $result['cash'] = self::getTransactionsCash($model);
        $result['transactions'] = self::getTransactionsTypes($model);
        $result['tickers'] = self::getTransactionsTickers($model);

        return $result;
    }
}
