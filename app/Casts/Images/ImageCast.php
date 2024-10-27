<?php

namespace App\Casts\Images;

use Yonchando\CastAttributes\CastAttributes;

class ImageCast extends CastAttributes
{
    public ?string $filename = null;

    public ?string $originalName = null;

    public ?string $path = null;

    public ?string $url = null;

    public ?string $extension = null;
}
