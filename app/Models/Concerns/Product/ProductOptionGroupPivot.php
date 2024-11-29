<?php

namespace App\Models\Concerns\Product;

use App\Models\Concerns\ProductHasOptionGroup\HasRelationships;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOptionGroupPivot extends Pivot
{
    use HasRelationships;

    public $incrementing = true;

    protected $with = ['product', 'productHasOptions.productOption', 'productOptionGroup'];
}
