<?php

namespace App\ValueObjects\Product;

use App\ValueObjects\ValueObject;
use Illuminate\Contracts\Support\Arrayable;

class ProductObject extends ValueObject implements Arrayable
{
    public string $published_at;
}