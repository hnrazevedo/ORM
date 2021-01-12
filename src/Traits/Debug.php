<?php

namespace HnrAzevedo\ORM;

class Debug
{
    public function __construct(
        private string $query = '',
        private array $data = []
    )
    {}

    public function handle(bool $array = false): string|array
    {
        if($array){
            return [
                'query' => $this->lastQuery, 
                'data' => $this->lastData
            ];
        }
        
        $query = $this->lastQuery;

        foreach($this->lastData as $name => $value){
            $query = str_replace(":{$name}", "'{$value}'", $query);
        }

        return $query;
    }    
}
