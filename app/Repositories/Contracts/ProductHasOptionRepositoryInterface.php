<?php

namespace App\Repositories\Contracts;

use App\Models\ProductHasOption;

interface ProductHasOptionRepositoryInterface
{
    public function create($product_has_option_group_id, $product_option_id, $price): ProductHasOption;

    public function destroy(array|int $ids): bool;
}