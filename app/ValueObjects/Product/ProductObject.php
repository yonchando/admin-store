<?php

namespace App\ValueObjects\Product;

use App\ValueObjects\JsonProperty;
use App\ValueObjects\ImageProperty;

class ProductObject extends JsonProperty
{
    public ImageProperty $image;
}
