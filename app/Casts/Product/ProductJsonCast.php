<?php

namespace App\Casts\Product;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Yonchando\CastAttributes\Traits\CastProperty;

class ProductJsonCast implements CastsAttributes
{
    use CastProperty;
    
    public ImageProperty $image;

    public function get(Model $model, string $key, mixed $value, array $attributes): ProductJsonCast
    {
        return self::create(json_decode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode($value);
    }
}
