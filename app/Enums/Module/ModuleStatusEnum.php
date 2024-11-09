<?php

namespace App\Enums\Module;

use App\Traits\HasEnumProperty;

enum ModuleStatusEnum: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
