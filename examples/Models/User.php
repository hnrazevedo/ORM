<?php

namespace Model;

use HnrAzevedo\ORM\Attributes\Entity;
use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Attributes\Validate;
use HnrAzevedo\ORM\Model;

#[Entity(table: 'User')]
class User extends Model
{
    #[Validate(max: 11)]
    #[Column(type: 'bigint', primaryKey: true, autoIncrement: true)]
    protected int $id;

    #[Validate(max: 50, min: 5)]
    #[Column(name: 'name', type: 'varchar')]
    protected string $name;

    #[Validate(max: 50)]
    #[Column(name: 'password', type: 'varchar', length: 50)]
    protected string $password;

    #[Validate(regex: "[0-9]{4}\-[0-9]{2}\-[0-9]{2}")]
    #[Column(name: 'birth', type: 'date')]
    protected string $birth;

    #[Validate(regex: "[0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-9]{2}\:[0-9]{2}\:[0-9]{2}")]
    #[Column(name: 'register', type: 'datetime')]
    protected string $register;

    #[Validate(nullable: false)]
    #[Column(name: 'address', type: 'bigint', length: 11, foreignKey: true)]
    protected Address $address;

    public function __construct()
    {
        parent::__construct();
    }

}
