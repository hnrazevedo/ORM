<?php

define("ORM_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "charset" => "utf8",
    "port" => 3306,
    "username" => "root",
    "password" => "",
    "database" => "",
    "timezone" => "America/Sao_Paulo",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
    ],
    "lang" => "pt_br"
]);