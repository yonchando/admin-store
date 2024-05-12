<?php

namespace App\Enums\Product;

use App\Traits\HasEnumProperty;

enum ProductStatus: string
{
    use HasEnumProperty;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
