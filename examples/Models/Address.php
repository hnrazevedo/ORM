<?php

namespace Model;

use HnrAzevedo\ORM\Attributes\Entity;
use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Model;

#[Entity(table: 'Address')]
class Address extends Model
{
    #[Column(name: 'id', type: 'bigint', length: 11, primaryKey: true, autoIncrement: true)]
    public int $id;

    #[Column(name: 'code', type: 'bigint', length: 8)]
    public string $code;

    #[Column(name: 'estate', type: 'varchar', length: 2)]
    public string $estate;

    #[Column(name: 'city', type: 'varchar', length: 25)]
    public string $city;

    #[Column(name: 'district', type: 'varchar', length: 25)]
    public string $district;

    #[Column(name: 'address', type: 'varchar', length: 25)]
    public string $address;

    #[Column(name: 'number', type: 'int', length: 5)]
    public string $number;

    #[Column(name: 'complement', type: 'varchar', length: 20, nullable: true)]
    public string $complement;

}
