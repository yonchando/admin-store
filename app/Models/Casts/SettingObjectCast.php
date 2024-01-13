<?php

namespace App\Models\Casts;

use App\ValueObjects\Setting\SettingObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class SettingObjectCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): SettingObject
    {
        return new SettingObject(json_decode($value, true));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if (!$value instanceof SettingObject && !is_string($value)) {
            throw new InvalidArgumentException('The given value is not a SettingObject instance');
        }

        return [
            'properties' => json_encode($value->toArray()),
        ];
    }
}