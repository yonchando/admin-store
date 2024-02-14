<?php

namespace App\Models\Concerns\PurchaseOrder;

use App\Enums\PurchaseOrder\PurchaseOrderStatus;
use App\Facades\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttributes
{
    public function purchasedDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->purchased_at->format('d-M-Y | h:i A'),
        );
    }

    public function statusText(): Attribute
    {
        return Attribute::make(
            get: function () {
                $status = $this->status;

                return match ($status) {
                    PurchaseOrderStatus::ACCEPTED => "<span class='badge badge-success'>$status->name</span>",
                    PurchaseOrderStatus::SHIPPED => "<span class='badge badge-info'>$status->name</span>",
                    PurchaseOrderStatus::CANCELED, PurchaseOrderStatus::REJECTED => "<span class='badge badge-danger'>$status->name</span>",
                    default => "<span class='badge badge-warning'>{$status->name}</span>"
                };
            }
        );
    }

    public function totalPriceText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_price.' '.Helper::setting()?->currency?->code
        );
    }
}

