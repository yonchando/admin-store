<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\ProductOpion\ProductOptionGroupRequest;
use App\Models\Product;
use App\Models\ProductOptionGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ProductOptionGroupRepositoryInterface
{

    /**
     * @param  Request  $request
     * @return Collection<ProductOptionGroup>
     */
    public function get(Request $request): Collection;

    public function store(ProductOptionGroupRequest $request): ProductOptionGroup;

    public function update(ProductOptionGroupRequest $request, ProductOptionGroup $group): ProductOptionGroup;

    public function find(int $id): ProductOptionGroup;

    public function destroy(int $id): bool;

}