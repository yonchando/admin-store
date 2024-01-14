<?php

namespace App\Providers;

use App\Enums\EnumService;
use App\Helpers\HelperService;
use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HelperService::class, HelperService::class);
        $this->app->singleton(EnumService::class, EnumService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');
    }
}
