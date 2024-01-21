<?php

namespace App\Repositories;

use App\Http\Requests\ProductOptionRequest;
use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductOptionRepository implements Contracts\ProductOptionRepositoryInterface
{

    public function get(Request $request): Collection
    {
        return ProductOption::get();
    }

    public function store(ProductOptionRequest $request): ProductOption
    {
        $option = new ProductOption();

        $option->fill($request->validated());

        $option->save();

        return $option;
    }

    public function update(ProductOptionRequest $request, ProductOption $productOption): ProductOption
    {
        $productOption->fill($request->validated());
        $productOption->save();

        return $productOption;
    }

    public function destroy(ProductOption $productOption): bool
    {
        // TODO: Implement destroy() method.
    }
}