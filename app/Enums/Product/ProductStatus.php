<?php

namespace App\Enums\Product;

enum ProductStatus
{
    case ACTIVE;
    case INACTIVE;

    public static function toArray(): array
    {
        return collect(self::cases())->map(fn($value) => ['name' => $value->name])->toArray();
    }
}