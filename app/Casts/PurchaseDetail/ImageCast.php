<?php

namespace App\Casts\PurchaseDetail;

use App\Casts\ImageProperty;
use Yonchando\CastAttributes\CastAttributes;

class ImageCast extends CastAttributes
{
    public ImageProperty $image;
}
