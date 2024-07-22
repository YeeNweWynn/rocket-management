<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RocketSDK;
use App\Services\RocketSDKInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RocketSDKInterface::class, RocketSDK::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
