<?php

namespace App\Repositories;

use App\Models\ProductHasOptionGroup;
use Illuminate\Database\Eloquent\Collection;

class ProductHasOptionGroupRepository implements Contracts\ProductHasOptionGroupRepositoryInterface
{

    public function get(): Collection
    {
        return ProductHasOptionGroup::get();
    }

    public function create(int $product_id, int $product_option_group_id): ProductHasOptionGroup
    {
        return ProductHasOptionGroup::create([
            'product_option_group_id' => $product_option_group_id,
            'product_id' => $product_id,
        ]);
    }
}