<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/Models/User.php';

use Model\User;

$user = new User();

$user->name = 'teste';

$user->find();