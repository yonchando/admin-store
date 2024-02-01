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
        return resolve(SettingObject::class)->setData(json_decode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value ? json_encode($value) : null;
    }
}