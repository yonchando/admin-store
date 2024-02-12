<?php

namespace App\Models;

use App\Models\Concerns\ProductHasOptionGroup\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHasOptionGroup extends Model
{
    use HasRelationships;
    use HasFactory;

    protected $fillable = [
        'product_option_group_id',
        'product_id',
    ];
}
