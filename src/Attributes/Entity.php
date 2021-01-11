<?php

namespace HnrAzevedo\ORM\Attributes;

use Attribute;

#[Attribute]
class Entity
{
    public function __construct(
        private string $table,
        private array $propertys = []
    )
    {}

    public function getTable(): string
    {
        return $this->table;
    }

    public function setProperty(string $name, string $attribute, $value): void
    {
        $this->propertys[$name][$attribute] = $value;
    }

    public function getProperty(string $name, string $attribute)
    {
        return $this->propertys[$name][$attribute];
    }

    

}
