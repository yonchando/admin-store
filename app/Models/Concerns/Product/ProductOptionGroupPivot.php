<?php

namespace App\Models\Concerns\Product;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Concerns\ProductHasOptionGroup\HasRelationships;

class ProductOptionGroupPivot extends Pivot
{
    use HasRelationships;

    public $incrementing = true;

    protected $with = ['product', 'productHasOptions.productOption', 'productOptionGroup'];
}