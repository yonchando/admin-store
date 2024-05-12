<?php

namespace App\Enums\Card;

use App\Traits\HasEnumProperty;

enum CardStatusEnum: string
{
    use HasEnumProperty;
    
    case ACTIVE = 'active';
    case SUSPENSE = 'suspense';
    case BLOCK = 'block';
}
