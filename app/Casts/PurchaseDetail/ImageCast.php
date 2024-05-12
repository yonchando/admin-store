<?php

namespace App\Casts\PurchaseDetail;

use App\ValueObjects\ImageProperty;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ImageCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): ImageProperty
    {
        return new ImageProperty(json_decode($value));
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if($value instanceof ImageProperty){
            return json_encode($value->toArray());
        }
        
        return json_encode($value);
    }
}
