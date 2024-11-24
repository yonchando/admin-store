<?php

namespace App\Providers;

use App\Helpers\HelperService;
use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::enforceMorphMap([
            'staff' => Staff::class,
            'customer' => Customer::class,
        ]);

        app()->bind(LengthAwarePaginator::class, function ($values, $data) {

            if ((int) $data['perPage'] == 15) {
                $data['perPage'] = 20;
            }

            $paginate = new LengthAwarePaginator(...$data);

            return $paginate->onEachSide(1)->withQueryString();
        });
        Vite::prefetch(concurrency: 3);
    }
}
