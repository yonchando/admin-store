<?php

namespace App\Models\Concerns\PurchaseDetail;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRelationships
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}