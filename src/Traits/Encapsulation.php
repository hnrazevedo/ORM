<?php

namespace HnrAzevedo\ORM\Traits;

use HnrAzevedo\ORM\ORMException;
use HnrAzevedo\ORM\Validation;

trait Encapsulation
{
    public function persist(): self
    {
        Validation::handle($this);
        die();

        $columns = '';
        $values = '';
        $data = [];

        foreach ($this->data as $key => $value) {
            if(strstr($this->data[$key]['extra'], 'auto_increment')){
                continue;
            }

            $this->checkMaxlength($key, $value['value'], $value['maxlength']);

            $columns .= $key.',';
            $values .= ':'.$key.',';
            $data[$key] = $value['value'];
        }

        $this->transaction('begin');
        try{
            $this->checkUniques($data);
            $id = $this->insert($data);
            $this->check_fail();
            $primary = $this->primary;
            $this->$primary = $id;
            $this->transaction('commit');
        }catch(ORMException $er){
            $this->transaction('rollback');
            throw $er;
        }

        return $this;
    }

    public function remove(bool $exec = false): self
    {
        if(!$exec){
            $this->clause = 'remove';    
            return $this;
        }

        $this->clause = null;

        if(count($this->where) == 1){
            $this->delete("{$this->primary}=:{$this->primary}", "{$this->primary}={$this->getData()[$this->primary]['value']}");
            $this->failed();
            return $this;
        }

        $this->delete(
            $this->mountRemove()['where'], 
            substr( $this->mountRemove()['data'] ,0,-1)
        );

        $this->check_fail();
            
        return $this;
    }

    public function save(): self
    {
        $this->transaction('begin');

        try{
            $this->checkForChanges();

            $this->update(
                $this->mountSave()['data'],
                "{$this->primary}=:{$this->primary}", 
                $this->primary.'='.$this->getData()[$this->primary]['value']
            );

            $this->check_fail();

            $this->transaction('commit');
        }catch(ORMException $er){
            $this->transaction('rollback');
            throw $er;
        }

        return $this;
    }
    
}
