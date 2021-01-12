<?php

namespace HnrAzevedo\ORM;

class Prepare
{
    public function __construct(private Model $model)
    {}

    private function filter(array $data): array
    {
        $filtered = [];
        foreach ($data as $key => $value) {
            $filtered[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filtered;
    }

    public function save(): array
    {
        $data = [];
        foreach($this->model->entity->getPropertys() as $p => $property){
            $value = $this->model->$p;
            if($property['Column']->isForeignKey()){
                $key = $this->model->$p->entity->getPrimaryKey()->getName();
                $value = $this->model->$p->$key;
            }
            if(null === $value){
                continue;
            }
            $data[$property['Column']->getName()] = $value;
        }
        return $this->filter($data);
    }
}
