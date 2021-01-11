<?php

namespace HnrAzevedo\ORM\Traits;

use HnrAzevedo\ORM\ORMException;
use HnrAzevedo\ORM\Connection;
use PDO;

trait Crud
{
    use Checking;

    protected ?ORMException $fail = null;
    protected string $lastQuery = '';
    protected array $lastData = [];

    protected function failed(): void
    {
        if(!is_null($this->fail)){
            throw $this->fail;
        }
    }

    protected function transaction(string $transaction): bool
    {
        if(array_key_exists($transaction, ['begin', 'commit', 'rollback'])){
            throw new ORMException("{$transaction} " . self::$ORM_LANG['notTransaction']);
        }

        if(!Connection::getInstance()->inTransaction()){
           return Connection::getInstance()->beginTransaction();
        }

        switch ($transaction) {
            case 'commit': return Connection::getInstance()->commit();
            default: return Connection::getInstance()->rollBack();
        }
    }

    protected function select(string $query, array $data): ?array
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

    protected function insert(array $data): string
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connection::getInstance()->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");

            $this->checkNull($data);
            $dataInsert = $this->filter($data);

            $this->lastQuery = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
            $this->lastData = $dataInsert;

            $stmt->execute($dataInsert);

            return Connection::getInstance()->lastInsertId();
        } catch (\Exception $exception) {
            $this->fail = new ORMException($exception->getMessage(), $exception->getCode(), $exception);
        }
        return '';
    }

    protected function update(array $data, string $terms, string $params): bool
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);

            parse_str($params, $arr);

            $dataUpdate = $this->filter(array_merge($data, $arr));

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

    private function filter(array $data): array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
        }
        return $filter;
    }

}
