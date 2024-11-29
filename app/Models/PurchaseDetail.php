<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category_name',
        'qty',
        'price',
        'sub_total',
        'json',
        'product_id',
        'purchase_id',
    ];

    protected function casts(): array
    {
        return [
            'json' => 'json',
            'price' => 'decimal:2',
            'sub_total' => 'decimal:2',
        ];
    }
}
