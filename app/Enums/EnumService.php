<?php

namespace App\Enums;

use BackedEnum;
use Illuminate\Support\Str;
use UnitEnum;

class EnumService
{
    public function toArray(array $enum, $getValue = false): array
    {
        return collect($enum)->map(fn ($value) => $getValue ? $value->value : $value->name)->toArray();
    }

    public function toSelectedForm(array $enum, $getValue = false): array
    {
        return collect($enum)->map(fn ($value) => [
            'id' => $getValue ? $value->value : $value->name,
            'text' => $getValue ? $value->value : $value->name,
        ])->toArray();
    }

    public function trans(UnitEnum|BackedEnum|null $enum, bool $getVlaue = false): ?string
    {
        if (is_null($enum)) {
            return null;
        }
        return __("lang." . Str::lower($getVlaue ? $enum->value : $enum->name));
    }
}
