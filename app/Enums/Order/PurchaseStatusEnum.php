<?php

namespace App\Enums\Order;

use App\Traits\HasEnumProperty;

enum PurchaseStatusEnum: string
{
    use HasEnumProperty;

    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
    case CANCEL = 'cancel';
}
