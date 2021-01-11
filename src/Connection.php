<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\ORMException;

class Connection
{
    private static ?\PDO $instance;

    public static function getInstance(): \PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new \PDO(
                    ORM_CONFIG['driver'] . ':host='.ORM_CONFIG['host'] . ';port='.ORM_CONFIG['port'] . ';dbname='. ORM_CONFIG['database'] . ';charset='.ORM_CONFIG['charset'],
                    ORM_CONFIG['username'],
                    ORM_CONFIG['password'],
                    ORM_CONFIG['options']
                );
            } catch (\PDOException $e) {
                throw new ORMException($e->getMessage(), $e->getCode(), $e);
            }
        }
        return self::$instance;
    }

    public static function destroy()
    {
        self::$instance = null;
    }

}
