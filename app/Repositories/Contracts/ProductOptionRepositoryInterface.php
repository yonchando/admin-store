<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\ProductOptionRequest;
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

    public function update(ProductOptionRequest $request, ProductOption $productOption): ProductOption;

    public function destroy(ProductOption $productOption): bool;

    /**
     * @param  int  $id
     * @return Collection<ProductOption>
     */
    public function findByGroupId(int $id): Collection;
}