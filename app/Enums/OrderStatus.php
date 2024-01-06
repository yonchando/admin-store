<?php

namespace App\Enums;

enum OrderStatus
{
    case PENDING;
    case ACCEPTED;
    case SHIPPED;
    case DELIVERED;
    case CANCELED;
}
