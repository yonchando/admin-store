<?php

namespace App\Models\Concerns\Product;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRelationships
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }

}