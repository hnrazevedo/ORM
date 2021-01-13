<?php

namespace HnrAzevedo\ORM;

class CRUD
{
    private string $query;
    private array $data;

    public function transaction(string $t): bool
    {
        if(array_key_exists(strtolower($t), ['begin', 'commit', 'rollback'])){
            throw new ORMException("{$t} " . self::$ORM_LANG['notTransaction']);
        }

        switch(strtolower($t)){
            case 'begin': return Connection::getInstance()->beginTransaction();
            case 'commit': return Connection::getInstance()->commit();
            default: return Connection::getInstance()->rollBack();
        }
    }

    public function insert(array $data, string $table): ?int
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $this->query = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
            $this->data = $data;

            $stmt = Connection::getInstance()->prepare($this->query);
            $stmt->execute($this->data);

            return intval(Connection::getInstance()->lastInsertId());
        } catch (\Exception $e) {
            throw new ORMException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function select(array $columns, string $table, array $terms, ?int $limit = null, ?int $offset = null, string $orderBy = ''): array|Object
    {
        try{
            $columns = implode(", ", array_keys($columns));

            $termed = $this->getTerms($terms);
            $limited = $this->getLimit($limit);
            $offseted = $this->getOffset($offset);

            $this->query = "SELECT {$columns} FROM {$table} WHERE 1 = 1 {$termed} {$limited} {$offseted} {$orderBy}";
            $this->data = $terms;

            $stmt = Connection::getInstance()->prepare($this->query);
            $stmt->execute($terms);

            return $stmt->fetchAll();
        }catch(\Exception $e){
            throw new ORMException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function update(array $data, array $terms, string $table): bool
    {
        try {
            $dataSet = [];
            foreach ($data as $column => $value) {
                $dataSet[] = "{$column} = :{$column}";
            }

            $this->query = "UPDATE {$table} SET ({$dataSet}) WHERE 1 = 1 {$terms}";
            $this->data = $data;

            $stmt = Connection::getInstance()->prepare($this->query);
            $stmt->execute($this->data);

            return ($stmt->rowCount() !== 0);
        } catch (\Exception $e) {
            throw new ORMException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function delete(string $terms, ?array $params = null): bool
    {
        try {
            $this->query = "DELETE FROM {$this->table} WHERE 1 = 1 {$terms}";
            $this->data = [];

            $stmt = Connection::getInstance()->prepare($this->query);
            $stmt->execute($params);
        
            return ($stmt->rowCount() !== 0);
        } catch (\Exception $e) {
            throw new ORMException($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function getTerms(array $terms): string
    {
        foreach ($terms as $condition => $term) {
            var_dump($term);
        }
        return '';
    }

    private function getLimit(?int $limit = null): string
    {
        return (null !== $limit) ? " LIMIT {$limit}" : '';
    }

    private function getOffset(?int $offset = null): string
    {
        return (null !== $offset) ? " OFFSET {$offset}" : '';
    }

    public function debug(bool $array = false): array|string
    {
        return (new  Debug(query: $this->query, data: $this->data))->handle($array);
    }

}
