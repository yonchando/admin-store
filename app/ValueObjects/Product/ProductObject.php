<?php

namespace App\ValueObjects\Product;

use App\ValueObjects\ValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ProductObject extends ValueObject implements Arrayable
{
    public function __construct(public ProductImage $image, array $data = null)
    {
        parent::__construct($data);
    }


}