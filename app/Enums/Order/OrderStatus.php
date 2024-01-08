<?php

namespace App\Enums\Order;

enum OrderStatus
{
    case PENDING;
    case ACCEPTED;
    case SHIPPED;
    case DELIVERED;
    case CANCELED;
}
