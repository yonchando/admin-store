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

    /**
     * @param  array{
     *     category_id: int,
     *     search: string,
     *     min_price: double,
     *     max_price: double,
     * }  $filters
     * @return LengthAwarePaginator<Product>|Collection<Product>
     */
    public function filterByAndPaginate(array $filters): LengthAwarePaginator|Collection;

    public function find(int $id): ?Product;

    public function store(ProductRequest $request): Product;

    public function update(ProductRequest $request, Product $product): Product;

    public function updateStatus(Product $product): Product;

    public function destroy(Product $product): void;

    public function findBySlug($slug): Product;
}
