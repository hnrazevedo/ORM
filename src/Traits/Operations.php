<?php

namespace HnrAzevedo\ORM\Traits;

use HnrAzevedo\ORM\CRUD;
use HnrAzevedo\ORM\ORMException;

trait Operations
{
    protected array $select = [];
    protected array $changed = [];
    protected array $terms = [];
    protected int $limit = 0;
    protected CRUD $manager;

    public function findById(int $key): self
    {
        $this->limit = 1;
        $key = $this->manager->select(columns: $this->select, table: $this->entity->getTable(), terms: $this->terms);
        $primaryKey = $this->entity->getPrimaryKey()->getName();


        var_dump($this->manager->debug());
        die();
        $this->$primaryKey = ($key);
    }

    public function removeById(int $key): self
    {
        return $this;
    }

    public function except(string|array $excepts): self
    {
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
