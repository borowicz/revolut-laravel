<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Revolut\AbstractRevolutModel;

class StockPrices extends AbstractRevolutModel
{
    use HasFactory;

    protected $fillable = [
            'hash',
            'source',
            'refreshed',
            'day',
            'ticker',
            'open',
            'high',
            'low',
            'close',
            'volume',
        ];

    public static function checkDailyPrice(string $ticker, string $transactionsDate)
    {
        $check = self::query()
            ->where('ticker', $ticker)
            ->where('disabled', 0)
            ->where(DB::raw('(DATE_FORMAT(day, "%Y-%m-%d"))'), $transactionsDate)
            ->first()
        ;

        return $check;
    }

    public static function getTickersDisabled()
    {
        $tableStockPrices = (new self)->getTable();
        $tableTicker = (new StockTicker())->getTable();

        $results = self::query()
            ->select($tableStockPrices . '.ticker')
            ->distinct()
            ->leftJoin(
                $tableTicker,
                $tableTicker . '.ticker',
                $tableStockPrices . '.ticker',
            )
            ->where($tableTicker . '.disabled', '=', 1)
            ->get()
            ->pluck('ticker');

        return $results->toArray();
    }

    public static function getLatestStockPricesList(string $ticker = null): array
    {
        $stockPricesTable = (new self())->getTable();

        // First, get the latest `refreshed_date` for each ticker
        $latestStockPrices = StockPrices::select(DB::raw('MAX(day) as max_date'), 'ticker')
            ->groupBy('ticker');
        if (null !== $ticker) {
            $latestStockPrices->where('ticker', $ticker);
        }

        $latestStockPricesWithDetails = StockPrices::joinSub(
            $latestStockPrices,
            'latest',
            function ($join) use ($stockPricesTable) {
                $join->on($stockPricesTable . '.ticker', '=', 'latest.ticker')
                    ->on($stockPricesTable . '.day', '=', 'latest.max_date');
            }
        )
            ->get()
            ->keyBy('ticker')
            ->toArray();

        return $latestStockPricesWithDetails;
    }

    public static function getTickersCounters()
    {
        $tableStockPrices = (new self)->getTable();
        $tableTicket = (new StockTicker())->getTable();

        $query = self::select($tableStockPrices . '.ticker')
            ->selectRaw('COUNT(' . $tableStockPrices . '.ticker) as counter')
            ->groupBy($tableStockPrices . '.ticker')
            ->leftJoin(
                $tableTicket,
                $tableTicket . '.ticker',
                $tableStockPrices . '.ticker',
            );

        $results = $query->pluck('counter', 'ticker');

        return $results->toArray();
    }
}
