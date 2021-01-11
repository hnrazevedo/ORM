<?php

namespace Model;

use HnrAzevedo\ORM\Attributes\Entity;
use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Model;

#[Entity(table: 'User')]
class User extends Model
{
    #[Column(type: 'bigint', length: 11, primaryKey: true, autoIncrement: true)]
    private int $id;

    #[Column(name: 'name', type: 'varchar', length: 50)]
    private string $name;

    #[Column(name: 'password', type: 'varchar', length: 50)]
    private string $password;

    #[Column(name: 'email', type: 'varchar', length: 100)]
    private string $email;

    #[Column(name: 'birth', type: 'date')]
    private string $birth;

    #[Column(name: 'register', type: 'datetime')]
    private string $register;

    #[Column(name: 'address', type: 'bigint', length: 11, foreignKey: true)]
    private Address $address;

    public function __construct()
    {
        parent::__construct();

        var_dump($this->entity);
    }

    public function __set(string $field, $value)
    {
        if(isset($this->$field)){
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
