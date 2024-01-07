<?php

namespace App\Providers;

use App\Repository\CategoryRepository;
use App\Repository\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $binds = [
        CategoryRepositoryInterface::class => CategoryRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->binds as $key => $bind) {
            $this->app->bind($key, $bind);
        }
    }

    public function boot(): void
    {
    }
}
