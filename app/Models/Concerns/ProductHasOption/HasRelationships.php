<?php

namespace App\Models\Concerns\ProductHasOption;

use App\Models\ProductHasOptionGroup;
use App\Models\ProductOption;

trait HasRelationships
{
    public function productOption()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }

    public function productHasOptionGroup()
    {
        return $this->belongsTo(ProductHasOptionGroup::class);
    }
}
