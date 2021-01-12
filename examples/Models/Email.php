<?php

namespace Model;

use HnrAzevedo\ORM\Attributes\Entity;
use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Model;

#[Entity(table: 'Email')]
class Email extends Model
{
    #[Column(name: 'id', type: 'bigint', length: 11, primaryKey: true, autoIncrement: true)]
    public int $id;

    #[Validate(max:100, filter: FILTER_VALIDATE_EMAIL)]
    #[Column(name: 'address', type: 'varchar')]
    public string $address;

    #[Column(name: 'user', type: 'bigint', length: 11, foreignKey: true)]
    public User $user;
}
