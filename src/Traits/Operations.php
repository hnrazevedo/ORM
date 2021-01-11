<?php

namespace HnrAzevedo\ORM\Traits;

trait Operations
{
    public function find(?int $key = null): self
    {
        return $this;
    }

    public function findById(int $key): self
    {
        return $this;
    }

    public function remove(?int $key = null): self
    {
        return $this;
    }

    public function removeById(int $key): self
    {
        return $this;
    }

    public function except(string|array $excepts): self
    {
        var_dump($excepts);
        return $this;
    }

    public function only(string|array $excepts): self
    {
        return $this;
    }

    public function toJson(): string
    {
        return '';
    }

    public function first(): self
    {
        return $this;
    }

    public function limit(int $limit): self
    {
        return $this;
    }

    public function offset(int $offset): self
    {
        return $this;
    }

    public function between(array $between): self
    {
        return $this;
    }

    public function where(array $where): self
    {
        return $this;
    }

    public function orderBy(string $column, ?string $type = null): self
    {
        return $this;
    }

    public function count(): int
    {
        return 0;
    }
}
