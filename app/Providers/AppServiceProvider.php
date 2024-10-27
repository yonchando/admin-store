<?php

namespace App\Providers;

use App\Helpers\HelperService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HelperService::class, HelperService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->bind(LengthAwarePaginator::class, function ($values, $data) {

            $paginate = new LengthAwarePaginator(...$data);

            return $paginate->onEachSide(1)->withQueryString();
        });
        Vite::prefetch(concurrency: 3);
    }
}
