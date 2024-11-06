<?php

namespace App\Enums\User;

use App\Traits\HasEnumProperty;

enum UserStatusEnum: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
