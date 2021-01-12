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

    public function getPropertys(): array
    {
        return $this->propertys;
    }

    public function hasPrimaryKey(): bool
    {
        foreach($this->getPropertys() as $property){
            if($property['Column']->isPrimaryKey()){
                return true;
            }
        }
        return false;
    }

    public function getPrimaryKey(): ?Column
    {
        foreach($this->getPropertys() as $property){
            if($property['Column']->isPrimaryKey()){
                return $property['Column'];
            }
        }
        return null;
    }

}
