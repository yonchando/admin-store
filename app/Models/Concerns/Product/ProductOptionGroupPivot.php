<?php

namespace App\Models\Concerns\Product;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductOptionGroupPivot extends Pivot
{
    public $incrementing = true;
}