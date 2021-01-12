<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config.php';
require __DIR__.'/Models/User.php';
require __DIR__.'/Models/Address.php';

use Model\User;
use Model\Address;

$user = new User();
$user->name = 'Henri Azevedo';
$user->password = '12345678';
$user->birth = date('Y-m-d');
$user->register = date('Y-m-d H:i:s');
$user->address = new Address();

//$user->address->id = 1;
$user->address->code = '00000000';
$user->address->estate = 'SP';
$user->address->city = 'Diadema';
$user->address->district = 'Inamar';
$user->address->address = 'Rua Canopo';
$user->address->number = 0;


$user->address->persist();
$user->persist();