<?php

namespace App\Casts;

use App\ValueObjects\ProductObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProductObjectCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): ProductObject
    {
        return new ProductObject($value ? json_decode($value,true) : []);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value ? json_encode($value) : null;
    }
}