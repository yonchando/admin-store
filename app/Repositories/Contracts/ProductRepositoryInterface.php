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
     * @param Request $request
     * @return Collection<Product>
     */
    public function get(Request $request): Collection;

    /**
     * @param Request $request
     * @return LengthAwarePaginator<Product>
     */
    public function paginate(Request $request): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Product
     */
    public function find(int $id): Product;

    /**
     * @param ProductRequest $request
     * @return Product
     */
    public function store(ProductRequest $request): Product;

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return Product
     */
    public function update(ProductRequest $request, Product $product): Product;

    /**
     * @param Product $product
     * @return void
     */
    public function destroy(Product $product): void;
}