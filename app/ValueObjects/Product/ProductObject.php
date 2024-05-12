<?php

namespace App\ValueObjects\Product;

use App\ValueObjects\JsonProperty;

class ProductObject extends JsonProperty
{
    public ProductImage $image;
}
