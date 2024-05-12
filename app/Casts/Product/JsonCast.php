<?php

namespace App\Casts\Product;

use App\ValueObjects\Product\ProductObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JsonCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ProductObject
    {
        return new ProductObject(json_decode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value ? json_encode($value) : null;
    }
}
