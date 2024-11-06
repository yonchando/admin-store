<?php

namespace App\Enums\Order;

use App\Traits\HasEnumProperty;

enum OrderStatusEnum: string
{
    use HasEnumProperty;

    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
}
