<?php

namespace App\Casts\Product;

use App\Casts\ImageProperty;
use Yonchando\CastAttributes\CastAttributes;

class JsonCast extends CastAttributes
{
    public ImageProperty $image;
}
