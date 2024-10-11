<?php

namespace App\Http\Controllers\Revolut;

use App\Models\Revolut\Stock\StockTransaction;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DashboardController extends AbstractRevolutController
{
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
            }
        }
        ksort($results);

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

            $currentModel = null;
            try {
                $currentModel = new $model();
                $current['info'] = self::getModelInfo($currentModel);
            } catch (\Exception $e) {
                continue;
            }

            $result[$model] = $current;
        }

        return $result;
    }

    public static function getModelInfo(mixed $model): array
    {
        $count = $model::count();
        if (0 === $count) {
            return [];
        }

        $result['count'] = $count;

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

            $current .= ', cash: ' . numberFormat($cash);

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
        $cash = StockTransaction::getTransactionsCash();

        return numberFormat($cash);
    }

    public static function getInfoStockTransactions(): array
    {
        $model = new StockTransaction();

        $result = [];
        $result['cash top up'] = self::getTransactionsCash($model);
        $result['transactions tickers'] = self::getTransactionsTypes($model);
        $result['stock tickers'] = self::getTransactionsTickers($model);

        return $result;
    }
}
