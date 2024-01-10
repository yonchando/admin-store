<?php

namespace App\Enums\Product;

use Illuminate\Support\Str;

enum ProductStatus
{
    case ACTIVE;
    case INACTIVE;

    public static function toArray(): array
    {
        return collect(self::cases())
            ->map(
                fn($value) => [
                    'name' => __("lang." . Str::lower($value->name)),
                    'id' => $value->name,
                ]
            )->toArray();
    }
}