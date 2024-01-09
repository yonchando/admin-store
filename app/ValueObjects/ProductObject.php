<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class ProductObject implements Arrayable
{
    public string $published_at;

    public function __construct(
        ?array $data = []
    )
    {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}