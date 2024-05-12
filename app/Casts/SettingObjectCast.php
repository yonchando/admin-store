<?php

namespace App\Casts;

use App\ValueObjects\Setting\SettingObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class SettingObjectCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): SettingObject
    {
        return new SettingObject(json_decode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if($value instanceof SettingObject){
            return json_encode($value->toArray());
        }
        
        return $value ? json_encode($value) : null;
    }
}
