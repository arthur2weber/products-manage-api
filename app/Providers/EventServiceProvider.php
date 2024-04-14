<?php

namespace App\Providers;

use App\Models\ProductModel;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ProductModel::observe(ProductObserver::class);
    }
}
