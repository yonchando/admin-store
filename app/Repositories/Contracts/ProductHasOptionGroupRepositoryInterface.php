<?php

namespace App\Repositories\Contracts;

use App\Models\ProductHasOptionGroup;
use Illuminate\Database\Eloquent\Collection;

interface ProductHasOptionGroupRepositoryInterface
{
    public function get(): Collection;

    public function create(int $product_id, int $product_option_group_id): ProductHasOptionGroup;

    public function destroy(mixed $id): bool;
}