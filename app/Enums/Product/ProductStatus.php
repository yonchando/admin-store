<?php

namespace App\Enums\Product;

use App\Traits\HasEnumProperty;

enum ProductStatus: string
{
    use HasEnumProperty;
    
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function severities(): array
    {
        return [
            self::ACTIVE->value => 'success',
            self::INACTIVE->value => 'error',
        ];
    }
}
