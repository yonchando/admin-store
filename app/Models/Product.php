<?php

namespace App\Models;

use App\Casts\Product\ProductJson;
use App\Enums\Product\ProductStatusEnum;
use App\Models\Concerns\Product\HasAttributes;
use App\Models\Concerns\Product\HasRelationships;
use App\Models\Concerns\Product\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property ProductJson $json
 */
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
        'stock_qty',
        'category_id',
        'image',
        'slug',
        'status',
        'json',
    ];

    protected $casts = [
        'json' => ProductJson::class,
        'price' => 'decimal:2',
        'status' => ProductStatusEnum::class,
        'created_at' => 'datetime:Y-m-d h:i A',
        'updated_at' => 'datetime:Y-m-d h:i A',
    ];

    protected $appends = [
        'image_url',
        'status_text',
    ];
}
