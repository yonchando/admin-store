<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;

class ValueObject
{
    public function __construct(array $data = null)
    {
        if (!is_null($data)) {
            $this->initializeProperties($data);
        }
    }

    protected function initializeProperties(array $data): void
    {
        foreach ($data as $property => $value) {
            if (property_exists($this, $property)) {
                $this->set($property, $value);
            }
        }
    }

    protected function set($property, $value): void
    {
        $this->$property = $value;
    }


    public function toArray(): array
    {
        $properties = get_object_vars($this);

        foreach ($properties as $key => $property) {
            if (is_object($property)) {
                if (!$property instanceof Arrayable) {
                    throw new InvalidArgumentException('Property is not Arrayable instance');
                }
                $properties[$key] = $property->toArray();
            }
        }

        return $properties;
    }

}