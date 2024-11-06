<?php

namespace App\Enums\Product;

use App\Traits\HasEnumProperty;

enum ProductStatusEnum: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
