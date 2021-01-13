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
                'query' => $this->query, 
                'data' => $this->data
            ];
        }
        
        $query = $this->query;

        foreach($this->data as $name => $value){
            $query = str_replace(":{$name}", "'{$value}'", $query);
        }

        return $query;
    }    
}
