<?php

namespace App\Models\Revolut\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Revolut\AbstractRevolutModel;

class StockPrices extends AbstractRevolutModel
{
    use HasFactory;

    protected $fillable = [
        'hash', 'source', 'refreshed', 'day', 'ticker', 'open', 'high', 'low', 'close', 'volume',
    ];

    public static function checkDailyPrice(string $ticker, string $transactionsDate)
    {
        return self::query()
            ->where('ticker', $ticker)
            ->where('disabled', 0)
            ->where(DB::raw('DATE_FORMAT(day, "%Y-%m-%d")'), $transactionsDate)
            ->first();
    }

    public static function getTickersDisabled()
    {
        $tableStockPrices = (new self)->getTable();
        $tableTicker = (new StockTicker())->getTable();

        return self::query()
            ->select($tableStockPrices . '.ticker')
            ->leftJoin($tableTicker, $tableTicker . '.ticker', $tableStockPrices . '.ticker')
            ->where($tableTicker . '.disabled', 1)
            ->pluck('ticker')
            ->toArray();
    }

    public static function getLatestStockPricesList(string $ticker = null): array
    {
        $stockPricesTable = (new self())->getTable();

        $latestStockPrices = StockPrices::select(DB::raw('MAX(day) as max_date'), 'ticker')
            ->groupBy('ticker');
        if ($ticker) {
            $latestStockPrices->where('ticker', $ticker);
        }

        return StockPrices::joinSub($latestStockPrices, 'latest', function ($join) use ($stockPricesTable) {
            $join->on($stockPricesTable . '.ticker', '=', 'latest.ticker')
                ->on($stockPricesTable . '.day', '=', 'latest.max_date');
        })
            ->get()
            ->keyBy('ticker')
            ->toArray();
    }

    public static function getTickersCounters()
    {
        $tableStockPrices = (new self)->getTable();
        $tableTicket = (new StockTicker())->getTable();

        return self::selectRaw($tableStockPrices . '.ticker, COUNT(' . $tableStockPrices . '.ticker) as counter')
            ->groupBy($tableStockPrices . '.ticker')
            ->leftJoin($tableTicket, $tableTicket . '.ticker', $tableStockPrices . '.ticker')
            ->pluck('counter', 'ticker')
            ->toArray();
    }
}
