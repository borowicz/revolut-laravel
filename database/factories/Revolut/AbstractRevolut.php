<?php

namespace Database\Factories\Revolut;

use Illuminate\Database\Eloquent\Factories\Factory;

abstract class AbstractRevolut extends Factory
{
    public static function getCommoditiesTickers(): array
    {
        return ['XAU', 'XAG'];
    }

    public static function getCryptoTickers(): array
    {
        return ['BTC', 'ETH', 'LTC', 'XRP'];
    }

    public static function getStockTransactionTypes(): array
    {
        return ['BUY', 'SELL', 'DIVIDEND'];
    }

    public static function getStockTickers(): array
    {
        return ['AAPL', 'AMD', 'AMZN', 'DB', 'F', 'GOOGL', 'META', 'NVDA', 'PLTR', 'PYPL', 'TSLA', 'TSM'];
    }
}
