<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RevolutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        dd(__DIR__ . '/../resources/views/livewire/revolut');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/livewire/revolut', 'revolut');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/livewire/partials', 'revolutPartials');
    }
}
