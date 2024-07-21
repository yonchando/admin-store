<?php

namespace App\Models;

use App\Casts\Product\ProductJsonCast;
use App\Enums\Product\ProductStatus;
use App\Models\Concerns\Product\HasAttributes;
use App\Models\Concerns\Product\HasRelationships;
use App\Models\Concerns\Product\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;
    use HasScopes;
    use SoftDeletes;

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
        'json' => ProductJsonCast::class,
        'price' => 'decimal:2',
        'status' => ProductStatus::class,
    ];

    protected $appends = [
        'image_url',
        'status_text',
    ];
}
