<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\Note\{CreateNote, EditNote, ShowNotes,};
use App\Livewire\Revolut\Stock\CashFlow\{CreateCash, ShowCash,};
use App\Livewire\Revolut\Stock\{
    Cash,
    Details,
    Dividends,
    Prices,
    PricesChart,
    Summary,
    TickersList,
    Transactions,
};
//use App\Livewire\Forms\UploadForm;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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
                    Route::get('/cash/flow', CreateCash::class)->name('stock.cash.flow');
                    Route::get('/cash/flow/create', ShowCash::class)->name('stock.cash.flow.create');
                });

                Route::get('/transactions', Transactions::class)->name('stock.transactions');
                Route::get('/transaction/details/{ticker}', Transactions::class)->name('stock.transactions.details');

                Route::get('/markets', Transactions::class)->name('stock.markets');

                Route::get('/tickers', Transactions::class)->name('stock.tickers');

                Route::get('/upload', Transactions::class)->name('stock.upload');
            });
        Route::prefix('crypto')->group(function () {
                Route::get('/', ShowNotes::class)->name('crypto.index');
            });
        Route::prefix('commodities')->group(function () {
                Route::get('/', ShowNotes::class)->name('commodities.index');
            });
        Route::prefix('accounts')->group(function () {
                Route::get('/', ShowNotes::class)->name('accounts.index');
            });
        Route::prefix('cash')->group(function () {
            Route::get('/', Transactions::class)->name('cash.index');
            Route::get('/details/{ticker}', Transactions::class)->name('cash.details');
            });
        Route::prefix('cron')->group(function () {
                Route::get('/', ShowNotes::class)->name('cron.index');
            });
    });

require __DIR__.'/auth.php';
