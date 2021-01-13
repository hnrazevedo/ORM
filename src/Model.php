<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Traits\Reflection;

class Model extends ORM
{
    use Reflection;

    public function __construct()
    {
        $this->interpret();
        $this->manager = new CRUD();
    }

    public function __set(string $field, $value)
    {
        if(property_exists($this, $field)){
            $this->$field = $value;
        }
    }

    public function __get(string $field)
    {
        if(!property_exists($this, $field)){
            throw new ORMException($field . ' not defined in ' . get_class($this));
        }
        return (isset($this->$field)) ? $this->$field : null;
    }

}
