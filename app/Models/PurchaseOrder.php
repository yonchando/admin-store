<?php

namespace App\Models;

use App\Enums\PurchaseOrder\PurchaseOrderStatus;
use App\Models\Concerns\PurchaseOrder\HasAttributes;
use App\Models\Concerns\PurchaseOrder\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasAttributes;
    use HasFactory;
    use HasRelationships;

    protected $fillable = [
        'customer_id',
        'total_price',
        'status',
        'purchased_at',
    ];

    protected $casts = [
        'status' => PurchaseOrderStatus::class,
        'purchased_at' => 'datetime',
    ];

    protected $appends = [
        'purchased_date',
        'status_text',
        'total_price_text',
    ];
}
