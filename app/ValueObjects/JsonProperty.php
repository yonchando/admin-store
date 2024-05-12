<?php

namespace App\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;
use stdClass;

class JsonProperty implements Arrayable, Jsonable
{
    /**
     * @var ReflectionProperty[]
     */
    private $properties;
    
    public function __construct(array|Collection|stdClass|null $data = null)
    {
        $reflectionClass = new ReflectionClass($this);

        $this->properties = $reflectionClass->getProperties();

        if (! is_null($data)) {
            $this->setProperties($data);
        }
    }

    protected function setProperties(mixed $data): static
    {
        foreach ($this->properties as $property) {
            $propertyName = $property->getName();
            if ($property->getType()->isBuiltin()) {
                $this->set($propertyName, data_get($data, Str::snake($propertyName)));
            } else {
                $className = $property->getType()->getName();
                $this->{$propertyName} = new $className(data_get($data, $propertyName, []));
            }
        }

        return $this;
    }

    protected function set($property, $value): void
    {
        $this->$property = $value;
    }

    public function toArray(): array
    {
        $properties = [];

        foreach ($this->properties as $property) {
            $propertyName = $property->getName();

            if ($property->getType()->isBuiltin()) {
                $properties[$propertyName] = Str::snake($property->getValue($this));
            } else {
                $properties[$propertyName] = $property->getValue($this)->toArray();
            }
        }

        return $properties;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
