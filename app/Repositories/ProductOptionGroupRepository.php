<?php

namespace App\Repositories;

use App\Http\Requests\ProductOpion\ProductOptionGroupRequest;
use App\Models\ProductOptionGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductOptionGroupRepository implements Contracts\ProductOptionGroupRepositoryInterface
{


    public function get(Request $request): Collection
    {
        return ProductOptionGroup::get();
    }

    public function store(ProductOptionGroupRequest $request): ProductOptionGroup
    {
        $group = new ProductOptionGroup($request->validated());
        $group->save();

        return $group;
    }

    public function update(ProductOptionGroupRequest $request, ProductOptionGroup $group): ProductOptionGroup
    {
        $group->fill($request->validated());
        $group->save();

        return $group;
    }

    public function find(int $id): ProductOptionGroup
    {
        return ProductOptionGroup::find($id);
    }

    public function destroy(int $id): bool
    {
        $group = ProductOptionGroup::find($id);

        if (is_null($group)) {
            abort(404);
        }

        return $group->delete();
    }
}