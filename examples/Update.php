<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config.php';
require __DIR__.'/Models/User.php';
require __DIR__.'/Models/Address.php';

try{

    $user = (new Model\User())->find(1)->handle();


    var_dump($user);
    die();
    $user->password = password_hash('87654321', PASSWORD_DEFAULT);

    $user->save();

}catch(HnrAzevedo\ORM\ORMException $e){

    die($e->getMessage());

}
