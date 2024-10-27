<?php

namespace App\Casts\Product;

use App\Casts\Images\ImageCast;
use Yonchando\CastAttributes\CastAttributes;

class ProductJson extends CastAttributes
{
    public ImageCast $image;
}
