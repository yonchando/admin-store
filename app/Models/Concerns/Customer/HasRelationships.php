<?php

namespace App\Models\Concerns\Customer;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasRelationships
{
    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'customer_id');
    }
}