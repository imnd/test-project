<?php

namespace App\Providers;

use App\Models\{
    Commodity, User
};
use App\Observers\{
    CommodityObserver, UserObserver
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        User::observe(UserObserver::class);
        Commodity::observe(CommodityObserver::class);
    }
}
