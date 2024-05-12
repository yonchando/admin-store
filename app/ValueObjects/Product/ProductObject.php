<?php

namespace App\ValueObjects\Product;

use App\ValueObjects\ImageProperty;
use App\ValueObjects\JsonProperty;

class ProductObject extends JsonProperty
{
    public ImageProperty $image;
}
