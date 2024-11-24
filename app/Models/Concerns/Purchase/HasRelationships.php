<?php

namespace App\Models\Concerns\Purchase;

use App\Models\Customer;
use App\Models\PurchaseDetail;
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
        return $this->hasMany(PurchaseDetail::class);
    }
}
