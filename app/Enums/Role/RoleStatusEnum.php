<?php

namespace App\Enums\Role;

use App\Traits\HasEnumProperty;

enum RoleStatusEnum: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
