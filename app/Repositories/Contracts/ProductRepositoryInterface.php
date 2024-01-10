<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
    public function filter(array $filters): LengthAwarePaginator|Collection;

    /**
     * @param  int  $id
     * @return Product|null
     */
    public function find(int $id): ?Product;

    /**
     * @param  ProductRequest  $request
     * @return Product
     */
    public function store(ProductRequest $request): Product;

    /**
     * @param  ProductRequest  $request
     * @param  Product  $product
     * @return Product
     */
    public function update(ProductRequest $request, Product $product): Product;

    public function updateStatus(Product $product): Product;

    /**
     * @param  Product  $product
     * @return void
     */
    public function destroy(Product $product): void;
}