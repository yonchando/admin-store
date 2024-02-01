<?php

namespace App\ValueObjects\Product;

use App\ValueObjects\ValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ProductImage extends ValueObject implements Arrayable
{
    public ?string $filename = null;
    public ?string $path = null;
    public ?string $url = null;
    public ?string $extension = null;

}