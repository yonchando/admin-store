<?php

namespace App\Enums\Staff;

use App\Traits\HasEnumProperty;

enum StaffStatusEnum: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
