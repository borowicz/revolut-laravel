<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RevolutServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/livewire/revolut', 'revolut');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/livewire/partials', 'revolutPartials');
    }
}
