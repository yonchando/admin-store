<?php

namespace App\Repositories;

use App\Http\Requests\ProductOptionRequest;
use App\Http\Requests\ProductOptionStoreManyRequest;
use App\Models\ProductOption;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductOptionRepository implements Contracts\ProductOptionRepositoryInterface
{

    public function get(Request $request): Collection
    {
        return ProductOption::latest()->get();
    }

    public function store(ProductOptionRequest $request): ProductOption
    {
        return ProductOption::create($request->validated());
    }


    public function storeMany(ProductOptionStoreManyRequest $request): Collection
    {
        $options = $request->get('options');

        $collect = ProductOption::newModelInstance()->newCollection();
        foreach ($options as $value) {
            $collect->push(ProductOption::create($value));
        }
      
        return $collect;
    }

    public function update(ProductOptionRequest $request, ProductOption $productOption): ProductOption
    {
        $productOption->fill($request->validated());
        $productOption->save();

        return $productOption;
    }

    public function destroy(int|array $ids): void
    {
        ProductOption::destroy($ids);
    }

    public function findByGroupId(int $id): Collection
    {
        $query = ProductOption::query();

        $query->findByGroupId($id);

        return $query->get();
    }

}