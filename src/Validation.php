<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Model;

class Validation
{
    public static function handle(Model $model): void
    {
        foreach($model->entity->getPropertys() as $name => $property){
            if(!array_key_exists('Validate', $property)){
                continue;
            }

            foreach($property['Validate']->getRules() as $r => $rule){
                $method = 'throw'.ucfirst($r);
                (new self())->$method($model->$name, $rule, $name);
            }
        }
    }

    private function throwNullable($value, $property, string $field): void
    {
       if(!$property && null === $value){
           throw new ORMException("{$field} cannot be null");
       }
    }

    private function throwMax($value, $property, string $field): void
    {
        if(isset($property) && strlen($value) > intval($property)){
            throw new ORMException("{$field} Cannot be greater than {$property}");
        }
    }

    private function throwMin($value, $property, string $field): void
    {
        if(isset($property) && strlen($value) < intval($property)){
            throw new ORMException("{$field} must be at least {$property} characters");
        }
    }

    private function throwRegex($value, $property, string $field): void
    {
        if(isset($property) && !preg_match($value, $property)){
            throw new ORMException("{$field} is invalid");
        }
    }

    private function throwFilter($value, $property, string $field): void
    {
        if(isset($property) && filter_var($value, $property)){
            throw new ORMException("{$field} did not pass filtering");
        }
    }
}
