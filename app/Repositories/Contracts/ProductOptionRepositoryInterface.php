<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\ProductOptionRequest;
use App\Http\Requests\ProductOptionStoreManyRequest;
use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ProductOptionRepositoryInterface
{
    /**
     * @return Collection<ProductOption>
     */
    public function get(Request $request): Collection;

    public function store(ProductOptionRequest $request): ProductOption;

    public function storeMany(ProductOptionStoreManyRequest $request): Collection;

    public function update(ProductOptionRequest $request, ProductOption $productOption): ProductOption;

    /**
     * @param  int|array<int>  $ids
     * @return void
     */
    public function destroy(int|array $ids): void;

    /**
     * @param  int  $id
     * @return Collection<ProductOption>
     */
    public function findByGroupId(int $id): Collection;

}