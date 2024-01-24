<?php

namespace App\Models\Concerns\Product;

use App\Models\Category;
use App\Models\ProductHasOptionGroup;
use App\Models\ProductOptionGroup;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRelationships
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function productHasOptionGroups()
    {
        return $this->hasMany(ProductHasOptionGroup::class);
    }

    public function productOptionGroups()
    {
        return $this->belongsToMany(
            ProductOptionGroup::class,
            ProductHasOptionGroup::class,
            'product_option_group_id',
            'product_id')
            ->using(ProductOptionGroupPivot::class);
    }

}