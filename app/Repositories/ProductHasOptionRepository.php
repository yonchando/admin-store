<?php

namespace App\Repositories;

use App\Models\ProductHasOption;

class ProductHasOptionRepository implements Contracts\ProductHasOptionRepositoryInterface
{

    public function create($product_has_option_group_id, $product_option_id, $price): ProductHasOption
    {
        return ProductHasOption::create([
            'product_has_option_group_id' => $product_has_option_group_id,
            'product_option_id' => $product_option_id,
            'price_adjustment' => $price,
        ]);

    }
}