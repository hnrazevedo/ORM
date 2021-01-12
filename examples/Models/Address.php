<?php

namespace Model;

use HnrAzevedo\ORM\Attributes\Entity;
use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Attributes\Validate;
use HnrAzevedo\ORM\Model;

#[Entity(table: 'Address')]
class Address extends Model
{
    #[Column(name: 'id', type: 'bigint', primaryKey: true, autoIncrement: true)]
    protected int $id;

    #[Validate(regex: '[0-9]{8}')]
    #[Column(name: 'code', type: 'bigint')]
    protected string $code;

    #[Validate(regex: '[a-zA-Z]{2}')]
    #[Column(name: 'estate', type: 'varchar')]
    protected string $estate;

    #[Validate(max: 25)]
    #[Column(name: 'city', type: 'varchar')]
    protected string $city;

    #[Validate(max: 25)]
    #[Column(name: 'district', type: 'varchar')]
    protected string $district;

    #[Validate(max: 25)]
    #[Column(name: 'address', type: 'varchar')]
    protected string $address;

    #[Validate(regex: '[0-9]{1,5}')]
    #[Column(name: 'number', type: 'int')]
    protected string $number;

    #[Validate(regex: '[a-zA-Z ]{20}')]
    #[Column(name: 'complement', type: 'string', nullable: true)]
    protected string $complement;
}
