<?php

namespace App\Enums\PurchaseOrder;

use App\Traits\HasEnumProperty;

enum PurchaseOrderStatus: string
{
    use HasEnumProperty;
    
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case SHIPPED = 'shipped';
    case CANCELED = 'canceled';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
}
