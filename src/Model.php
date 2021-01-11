<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Traits\Reflection;

class Model
{
    use Reflection;

    public function __construct()
    {
        $this->interpret();
    }

}