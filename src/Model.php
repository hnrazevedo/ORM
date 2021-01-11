<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Traits\Reflection;

class Model extends ORM
{
    use Reflection;

    public function __construct()
    {
        $this->interpret();
    }

}