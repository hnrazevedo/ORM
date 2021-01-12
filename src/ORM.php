<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Traits\Encapsulation;
use HnrAzevedo\ORM\Traits\Operations;

class ORM
{
    use Operations,
        Encapsulation;

    protected function debug(bool $array = false): string|array
    {
        return (new Debug($this->query, $this->data))->handle($array);
    }
}