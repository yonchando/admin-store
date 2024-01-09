<?php

namespace App\Models;

use App\Casts\ProductObjectCast;
use App\Enums\Product\ProductStatus;
use App\Models\Concerns\Product\HasAttributes;
use App\Models\Concerns\Product\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAttributes;
    use HasRelationships;

    protected $guarded = [
        'image_url'
    ];

    protected $casts = [
        'json' => ProductObjectCast::class,
        'price' => 'decimal:2',
        'status' => ProductStatus::class
    ];
    
    protected $appends = [
        'image_url'
    ];
}
