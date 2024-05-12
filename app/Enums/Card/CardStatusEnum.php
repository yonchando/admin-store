<?php

namespace App\Enums\Card;

enum CardStatusEnum: string
{
    case ACTIVE = "active";
    case SUSPENSE = 'suspense';
    case BLOCK = "block";
}
