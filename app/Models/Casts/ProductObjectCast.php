<?php

namespace App\Models\Casts;

use App\ValueObjects\Product\ProductObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProductObjectCast implements CastsAttributes
{
    private ProductObject $productObject;

    public function __construct()
    {
        $this->productObject = resolve(ProductObject::class);
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): ProductObject
    {
        return $this->productObject->setData($value ? json_decode($value) : []);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value ? json_encode($value) : null;
    }
}