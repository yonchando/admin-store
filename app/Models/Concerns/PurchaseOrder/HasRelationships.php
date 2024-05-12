<?php

namespace App\Models\Concerns\PurchaseOrder;

use App\Models\Customer;
use App\Models\PurchaseOrderDetail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasRelationships
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }
}
