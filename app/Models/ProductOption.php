<?php

namespace App\Models;

use App\Models\Concerns\ProductOption\HasAttributes;
use App\Models\Concerns\ProductOption\HasScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;
    use HasAttributes;
    use HasScopes;

    protected $fillable = [
        'name',
        'price_adjustment',
    ];

    protected $appends = [
        'price_adjustment_text',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
    ];
}
