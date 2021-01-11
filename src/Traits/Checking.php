<?php

namespace HnrAzevedo\ORM\Traits;

use HnrAzevedo\ORM\ORMException;

trait Checking
{
    protected static array $ORM_LANG = [];

    protected function throwDefined(): void
    {
        if(!defined('ORM_CONFIG')){
            throw new ORMException('Information for connection to the database not defined.');
        }
    }

    protected function checkWhereArray(array $where): void
    {
        if(count($where) != 3){
            throw new ORMException(self::$ORM_LANG['whereIntegrity'] . ": ".implode(' ',$where));
        }

        if(!array_key_exists($where[0], $this->data) && $this->full){
            throw new ORMException("{$where[0]} " . self::$ORM_LANG['fieldNotFound'] . " {$this->table}.");
        }
    }

    protected function isSettable(string $prop): void
    {
        if($this->full && !array_key_exists($prop, $this->data)){
            throw new ORMException("{$prop} " . self::$ORM_LANG['fieldNotFound'] . " {$this->table}.");
        }
    }

    protected function checkLimit(): void
    {
        if(is_null($this->limit)){
            throw new ORMException(self::$ORM_LANG['exceededLimit']);
        }
    }

    protected function checkMaxlength(string $field, $val , $max): void
    {
        if(strlen($val) > $max){
            throw new ORMException($this->getField($field) . " " . self::$ORM_LANG['exceededMaxlength'] . " {$this->table}");
        }
    }

    protected function checkSettable(string $field, $val , $max): void
    {   
        if($this->options['maxlength']){
            $this->checkMaxlength($field, $val, $max);
        }
    }

    protected function upgradeable(string $field): bool
    {
        return (($this->data[$field]['changed'] && $this->data[$field]['upgradeable']) || $this->primary === $field);
    }

    protected function isIncremented(string $field): bool
    {
        return ( strstr($this->data[$field]['extra'], 'auto_increment') && $field === $this->primary );
    }

    protected function checkForChanges(): bool
    {
        $hasChanges = false;
        foreach($this->data as $data){
            if($data['changed']){
                $hasChanges = true;
            }
        }
        if(!$hasChanges){
            throw new ORMException(self::$ORM_LANG['dontUpdate']);
        }
        return true;
    }

    protected function checkUniques($data): void
    {
        foreach($this->data as $d => $dd){
            if($dd['key'] === 'UNI'){
                $exist = $this->find()->where([$d,'=', $data[$d]])->only('id')->execute()->getCount();
                if($exist > 0){
                    throw new ORMException(self::$ORM_LANG['duplicity'] . " {$this->getField($d)}.");
                }
            }
        }
    }

    protected function checkNull(array $data): void
    {
        foreach($this->data as $input => $attr){
            if(!array_key_exists($input, $data)){
                continue;
            }
            if(($attr['null'] === 0) && (null === $data[$input])){
                throw new ORMException($this->getField($input) . " " . self::$ORM_LANG['notNull']);
            }
        }
    }

}
