<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Attributes\Column;
use HnrAzevedo\ORM\Model;

class Validation
{
    public static function handle(Model $model): void
    {
        foreach($model->entity->getPropertys() as $name => $property){
            if(!array_key_exists('Validate', $property)){
                continue;
            }

            $rules = $property['Validate']->getRules();
            $column = $property['Column'];

            foreach($rules as $r => $rule){
                $method = 'throw'.ucfirst($r);
                (new self())->$method($model->$name, $rule, $name, $column);
            }
        }
    }

    private function throwNullable($value, $property, string $field, Column $column): void
    {
        if($this->isNullable($value, $column)){
            return;
        }

        if(!$property && !$column->isAutoIncrement() && null === $value){
            throw new ORMException("{$field} cannot be null");
        }

        if(gettype($value) === 'object'){
            $this->throwForeignKey($value, $property);
        }
    }

    private function throwForeignKey(Object $value, $property): void
    {
        $key = $value->entity->getPrimaryKey()->getName();

        //if(!$property && null === $value->$key){
        //    throw new ORMException($key . ' in ' . $value::class . ' cannot be null');
        //}
        
        $this->handle($value);
    }

    private function throwMax($value, $property, string $field, Column $column): void
    {
        if($this->isNullable($value, $column)){
            return;
        }

        if(isset($property) && strlen($value) > intval($property)){
            throw new ORMException("{$field} Cannot be greater than {$property}");
        }
    }

    private function throwMin($value, $property, string $field, Column $column): void
    {
        if($this->isNullable($value, $column)){
            return;
        }

        if(isset($property)  && strlen($value) < intval($property)){
            throw new ORMException("{$field} must be at least {$property} characters");
        }
    }

    private function throwRegex($value, $property, string $field, Column $column): void
    {
        if($this->isNullable($value, $column)){
            return;
        }

        if(isset($property) && !preg_match("/^{$property}$/", $value)){
            throw new ORMException("{$field} is invalid");
        }
    }

    private function throwFilter($value, $property, string $field, Column $column): void
    {
        if($this->isNullable($value, $column)){
            return;
        }

        if(isset($property) && filter_var($value, $property)){
            throw new ORMException("{$field} did not pass filtering");
        }
    }

    private function isNullable($value, Column $column): bool
    {
        return (null === $value && $column->isNullable());
    }
}
