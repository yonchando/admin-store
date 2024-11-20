<?php

namespace App\Enums\Customer;

use App\Traits\HasEnumProperty;

enum CustomerStatusEnum: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
