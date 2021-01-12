<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/Models/User.php';
require __DIR__.'/Models/Address.php';

use Model\User;
use Model\Address;

$address = new Address();
$address->id = 1;
$address->code = '00000-000';
$address->estate = 'SP';
$address->city = 'Diadema';
$address->district = 'Inamar';
$address->address = 'Rua Canopo';
$address->number = 0;

$user = new User();
$user->name = 'Henri Azevedo';
$user->password = '12345678';
$user->birth = date('Y-m-d');
$user->register = date('Y-m-d H:i:s');
$user->address = $address;

$user->persist();