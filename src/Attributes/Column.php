<?php

namespace HnrAzevedo\ORM\Attributes;

use Attribute;

#[Attribute]
class Column
{
    public function __construct(
        private ?string $name = null,
        private string $type,
        private int $length = 255,
        private bool $nullable = false,
        private bool $unique = false,
        private ?string $default = null,
        private bool $primaryKey = false,
        private bool $foreignKey = false,
        private ?string $foreignEntity = null,
        private bool $autoIncrement = false
    )
    {}

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isUnique(): bool
    {
        return $this->unique;
    }

    public function getDefault(): string
    {
        return $this->default;
    }

    public function isPrimaryKey(): bool
    {
        return $this->primaryKey;
    }

    public function isForeignKey(): bool
    {
        return $this->foreignKey;
    }

    public function isAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

}
