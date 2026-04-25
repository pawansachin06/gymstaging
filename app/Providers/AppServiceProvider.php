<?php

namespace App\Providers;

use App\Services\TelegramService;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Laravel\Cashier\Cashier;
use View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFour();
        // Schema::defaultStringLength(255);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Cashier::ignoreMigrations();
        $this->app->singleton(TelegramService::class);
    }
}
