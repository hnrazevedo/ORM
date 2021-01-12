<?php

namespace Model;

use HnrAzevedo\ORM\Attributes\Entity;
use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Attributes\Validate;
use HnrAzevedo\ORM\Model;

#[Entity(table: 'User')]
class User extends Model
{
    #[Validate(max: 11, min: 1, regex: "[0-9]{1,11}")]
    #[Column(type: 'bigint', length: 11, primaryKey: true, autoIncrement: true)]
    private int $id;

    #[Validate(max: 50, min: 5)]
    #[Column(name: 'name', type: 'varchar', length: 50)]
    private string $name;

    #[Validate(max: 50)]
    #[Column(name: 'password', type: 'varchar', length: 50)]
    private string $password;

    #[Validate(filter: FILTER_VALIDATE_EMAIL)]
    #[Column(name: 'email', type: 'varchar', length: 100)]
    private string $email;

    #[Validate(regex: "[0-9]{4}\-[0-9]{2}\-[0-9]{2}")]
    #[Column(name: 'birth', type: 'date')]
    private string $birth;

    #[Validate(regex: "[0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-9]{2}\:[0-9]{2}\:[0-9]{2}")]
    #[Column(name: 'register', type: 'datetime')]
    private string $register;

    #[Column(name: 'address', type: 'bigint', length: 11, foreignKey: true)]
    private Address $address;

    public function __construct()
    {
        parent::__construct();
    }

    public function __set(string $field, $value)
    {
        if(property_exists($this, $field)){
            $this->$field = $value;
        }
    }

    public function __get(string $field)
    {
        if(isset($this->$field)){
            return $this->$field;
        }
    }

}
