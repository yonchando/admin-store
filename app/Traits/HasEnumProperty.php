<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasEnumProperty
{
    public static function toCollection(): Collection
    {
        return collect(self::cases());
    }

    public static function toArray(array $excepts = []): array
    {
        return collect(self::cases())
            ->map(
                fn($value) => [
                    'text' => __('lang.' . Str::lower($value->value)),
                    'id' => $value->value,
                ]
            )->filter(fn($value) => !in_array($value['id'], $excepts))
            ->toArray();
    }

    public static function toJson(): array
    {
        return collect(self::cases())
            ->flatMap(
                fn($value) => [
                    $value->name => $value->value,
                ]
            )->toArray();
    }
}
