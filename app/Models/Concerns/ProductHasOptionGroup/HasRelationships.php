<?php

namespace App\Models\Concerns\ProductHasOptionGroup;

use App\Models\Product;
use App\Models\ProductHasOption;
use App\Models\ProductOptionGroup;

trait HasRelationships
{
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productOptionGroup()
    {
        return $this->belongsTo(ProductOptionGroup::class, 'product_option_group_id');
    }

    public function productHasOptions()
    {
        return $this->hasMany(ProductHasOption::class, 'product_has_option_group_id', 'id');
    }
}
