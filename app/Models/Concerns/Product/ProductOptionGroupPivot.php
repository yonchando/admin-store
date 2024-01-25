<?php

namespace App\Models\Concerns\Product;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOptionGroupPivot extends Pivot
{
    use \App\Models\Concerns\ProductHasOptionGroup\HasRelationships;

    public $incrementing = true;

    protected $with = ['product', 'productHasOptions.productOption', 'productOptionGroup'];
}