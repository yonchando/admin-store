<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * @return Collection<Product>
     */
    public function get(): Collection;

    /**
     * @return LengthAwarePaginator<Product>
     */
    public function paginate(): LengthAwarePaginator;

    public function find(int $id): ?Product;

    public function store(ProductRequest $request): Product;

    public function update(ProductRequest $request, Product $product): Product;

    public function updateStatus(Product $product): Product;

    public function destroy(int|array $ids): void;

    public function findBySlug($slug): Product;
}
