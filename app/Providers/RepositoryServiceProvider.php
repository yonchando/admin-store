<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\PurchaseOrderInterface;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseOrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private $binds = [
        CategoryRepositoryInterface::class => CategoryRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        PurchaseOrderInterface::class => PurchaseOrderRepository::class,
        CustomerRepositoryInterface::class => CustomerRepository::class,
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
