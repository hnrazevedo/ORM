<?php

namespace HnrAzevedo\ORM\Traits;

trait Debug
{
    protected string $lastQuery = '';
    protected array $lastData = [];

    public function handle(bool $array = false): string|array
    {
        if($array){
            return ['query' => $this->lastQuery, 'data' => $this->lastData];
        }
        
        $query = $this->lastQuery;

        foreach($this->lastData as $name => $value){
            $query = str_replace(":{$name}", "'{$value}'", $query);
        }

        return $query;
    }    

}
