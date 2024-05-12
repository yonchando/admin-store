<?php

namespace App\Models;

use App\Casts\PurchaseDetail\ImageCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ref_product_id',
        'purchase_order_id',
        'product_name',
        'category_name',
        'qty',
        'price',
        'total_price',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'image' => ImageCast::class
        ];
    }


}
