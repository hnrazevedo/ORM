<?php

namespace HnrAzevedo\ORM\Attributes;

use Attribute;

#[Attribute]
class Validate
{
    public function __construct(
        private ?int $max = null,
        private ?int $min = null,
        private ?string $regex = null,
        private bool $nullable = false,
        private ?int $filter = null
    )
    {}

    public function getRules(): array
    {
        return get_object_vars($this);
    }
}
