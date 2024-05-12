<?php

namespace App\Casts\Setting;

use App\ValueObjects\Setting\SettingPropertyObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PropertyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): SettingPropertyObject
    {
        return new SettingPropertyObject(json_decode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if($value instanceof SettingPropertyObject){
            return json_encode($value->toArray());
        }
        
        return $value ? json_encode($value) : null;
    }
}
