<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RocketSDK;
use App\Services\RocketSDKInterface;
use App\Services\WeatherSDK;
use App\Services\WeatherSDKInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RocketSDKInterface::class, RocketSDK::class);
        $this->app->singleton(WeatherSDKInterface::class, WeatherSDK::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
