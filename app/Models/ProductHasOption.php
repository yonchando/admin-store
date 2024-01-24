<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasOption extends Model
{
    protected $fillable = [
        'product_has_option_group_id',
        'product_option_id',
        'price_adjustment',
    ];
}
