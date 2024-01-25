<?php

namespace App\Models\Concerns\Product;

use App\Models\Category;
use App\Models\ProductHasOption;
use App\Models\ProductHasOptionGroup;
use App\Models\ProductOption;
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

    public function productOptions()
    {
        return $this->hasManyThrough(ProductHasOption::class, ProductHasOptionGroup::class);
    }

    public function productOptionGroups()
    {
        return $this->belongsToMany(
            ProductOptionGroup::class,
            ProductHasOptionGroup::class,
            'product_id',
            'product_option_group_id'
        )
            ->withPivot(['id', 'created_at', 'updated_at'])
            ->using(ProductOptionGroupPivot::class);
    }

}