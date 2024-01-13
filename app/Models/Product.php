<?php

namespace App\Models;

use App\Enums\Product\ProductStatus;
use App\Models\Casts\ProductObjectCast;
use App\Models\Concerns\Product\HasAttributes;
use App\Models\Concerns\Product\HasRelationships;
use App\Models\Concerns\Product\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAttributes;
    use HasRelationships;
    use HasScopes;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'image',
        'slug',
        'status',
        'json',
    ];

    protected $casts = [
        'json' => ProductObjectCast::class,
        'price' => 'decimal:2',
        'status' => ProductStatus::class,
    ];

    protected $appends = [
        'image_url',
        'status_text',
    ];
}
