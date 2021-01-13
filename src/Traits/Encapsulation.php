<?php

namespace HnrAzevedo\ORM\Traits;

use HnrAzevedo\ORM\ORMException;
use HnrAzevedo\ORM\Prepare;
use HnrAzevedo\ORM\CRUD;

trait Encapsulation
{
    use Operations;
    private bool $work = false;
    private string 

    public function handle(): void
    {
        echo 1;
    }

    public function persist(): self
    {
        $this->manager->transaction('begin');
        try{
            $key = $this->manager->insert((new Prepare($this))->save(), $this->entity->getTable());
            $primaryKey = $this->entity->getPrimaryKey()->getName();
            $this->$primaryKey = ($key);
            $this->manager->transaction('commit');
        }catch(ORMException $er){
            $this->manager->transaction('rollback');
            throw $er;
        }
        return $this;
    }

    public function find(?int $key = null): array
    {
        try{
            return (null !== $key) 
                ? $this->findById($key)
                : $this->manager->select(columns: $this->select, table: $this->entity->getTable(), terms: $this->terms);
        }catch(ORMException $er){
            throw $er;
        }
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
