<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\Revolut\Dashboard;
use App\Livewire\Revolut\CurrencyToday;
use App\Livewire\Note\{CreateNote, EditNote, ShowNotes,};
use App\Livewire\Revolut\Money\{
    Summary as MoneySummary,
    Transactions as MoneyTransactions,
    TickersList as MoneyTickersList,
    Upload as MoneyUpload,
};
use App\Livewire\Revolut\Commodities\{
    Summary as CommoditiesSummary,
    Transactions as CommoditiesTransactions,
    TickersList as CommoditiesTickersList,
    Upload as CommoditiesUpload,
};
use App\Livewire\Revolut\Crypto\{
    Summary as CryptoSummary,
    Transactions as CryptoTransactions,
    TickersList as CryptoTickersList,
    Upload as CryptoUpload,
};
use App\Livewire\Revolut\Stock\CashFlow\{CreateCash, EditCash,};
use App\Livewire\Revolut\Stock\Markets\{CreateMarket, EditMarket};
use App\Livewire\Revolut\Stock\{
    CashFlow,
    Cash,
    Details,
    Dividends,
    Prices,
    PricesChart,
    Summary,
    TickersList,
    Transactions,
    Markets,
    Upload as StockUpload,
};

Route::get('/', function () {
    session(['last_login_at' => now()]);

    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard', Dashboard::getRevolutSummary());
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('jobs', 'dashboard')->middleware(['auth', 'verified'])->name('jobs.index');

Route::prefix('notes')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', ShowNotes::class)->name('notes.index');
        Route::get('/create', CreateNote::class)->name('notes.create');
        Route::get('/edit/{note}', EditNote::class)->name('notes.edit');
    });

Route::prefix('revolut')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::prefix('stock')->group(function () {
                Route::get('/', Summary::class)->name('stock.index');

                Route::get('/prices', Prices::class)->name('stock.prices');
                Route::get('/prices/detail', Prices::class)->name('stock.prices.details');

                Route::prefix('cash')->group(function () {
                    Route::get('/', Cash::class)->name('stock.cash');
                    Route::get('/flow', CashFlow::class)->name('stock.cash.flow');
                    Route::get('/flow/create', CreateCash::class)->name('stock.cash.flow.create');
                    Route::get('/flow/edit', EditCash::class)->name('stock.cash.flow.edit');
                });

                Route::get('/transactions', Transactions::class)->name('stock.transactions');
                Route::get('/transaction/details/{ticker}', Transactions::class)->name('stock.transactions.details');

                Route::prefix('markets')->group(function () {
                    Route::get('/', Markets::class)->name('stock.markets');
                    Route::get('/create', CreateMarket::class)->name('stock.markets.create');
                    Route::get('/edit/{id}', EditMarket::class)->name('stock.markets.edit');
                });

                Route::get('/tickers', TickersList::class)->name('stock.tickers');

                Route::get('/upload', StockUpload::class)->name('stock.upload');
            });

        Route::prefix('crypto')->group(function () {
                Route::get('/', CryptoSummary::class)->name('crypto.index');

                Route::get('/transactions', CryptoTransactions::class)->name('crypto.transactions');
                Route::get('/transaction/details/{ticker}', CryptoTransactions::class)->name('crypto.transactions.details');

                Route::get('/tickers', CryptoTickersList::class)->name('crypto.tickers');

                Route::get('/upload', CryptoUpload::class)->name('crypto.upload');
            });

        Route::prefix('commodities')->group(function () {
                Route::get('/', CommoditiesSummary::class)->name('commodities.index');

                Route::get('/transactions', CommoditiesTransactions::class)->name('commodities.transactions');
                Route::get('/transaction/details/{ticker}', CommoditiesTransactions::class)->name('commodities.transactions.details');

                Route::get('/tickers', CommoditiesTickersList::class)->name('commodities.tickers');

                Route::get('/upload', CommoditiesUpload::class)->name('commodities.upload');
            });

        Route::prefix('money')->group(function () {
                Route::get('/', MoneySummary::class)->name('money.index');

                Route::get('/transactions', MoneyTransactions::class)->name('money.transactions');
                Route::get('/transaction/details/{ticker}', MoneyTransactions::class)->name('money.transactions.details');

                Route::get('/tickers', MoneyTickersList::class)->name('money.tickers');

                Route::get('/upload', MoneyUpload::class)->name('money.upload');
            });

        Route::get('currency', CurrencyToday::class)->name('currency.index');

        Route::prefix('cron')->group(function () {
                Route::get('/', ShowNotes::class)->name('cron.index');
            });
    });

require __DIR__.'/auth.php';
