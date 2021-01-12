<?php

namespace HnrAzevedo\ORM;

use HnrAzevedo\ORM\Traits\Checking;
use PDO;

class CRUD
{
    use Checking;

    protected ?ORMException $fail = null;
    protected string $lastQuery = '';
    protected array $lastData = [];

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

    public function select(string $query, array $data): ?array
    {
        try{
            $stmt = Connection::getInstance()->prepare("{$query}");

            $this->lastQuery = "{$query}";
            $this->lastData = $data;

            $stmt->execute($data);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(\Exception $exception){
            $this->fail = new ORMException($exception->getMessage(), $exception->getCode(), $exception);
        }
        return [];
    }

    

    public function update(array $data, string $terms, string $params): bool
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);

            parse_str($params, $arr);

            //$dataUpdate = $this->filter(array_merge($data, $arr));

            $stmt = Connection::getInstance()->prepare("UPDATE {$this->table} SET {$dateSet} WHERE {$terms}");

            $this->lastQuery = "UPDATE {$this->table} SET {$dateSet} WHERE {$terms}";
            $this->lastData = $dataUpdate;

            $this->checkNull($data);
            $stmt->execute($dataUpdate);

            return ($stmt->rowCount() !== 0);
        } catch (\Exception $exception) {
            $this->fail = new ORMException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return true;
    }

    public function delete(string $terms, ?string $params): bool
    {
        try {
            $stmt = Connection::getInstance()->prepare("DELETE FROM {$this->table} WHERE {$terms}");

            $this->lastQuery = "DELETE FROM {$this->table} WHERE {$terms}";
            $this->lastData = [];

            if($params){
                parse_str($params, $arr);
                $this->lastData = $arr;

                $stmt->execute($arr);
                return ($stmt->rowCount() !== 0);
            }

            $stmt->execute();
            return ($stmt->rowCount() !== 0);

        } catch (\Exception $exception) {
            $this->fail = new ORMException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return false;
    }

    public function failed(): void
    {
        if(!is_null($this->fail)){
            throw $this->fail;
        }
    }

}
