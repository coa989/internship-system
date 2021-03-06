<?php

namespace app\src;

use app\db\Database;

abstract class Model extends Database
{
    public array $errors;

    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function rules(): array;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getAll($limit, $page, $sort, $order)
    {
        if ($limit === null || $limit === '' || !is_numeric($limit)) {
            $limit = 5;
        }
        
        if ($page === null || $page === '' || !is_numeric($page)) {
            $page = 1;
        }
        
        if ($sort === null || $sort === '') {
            $sort = 'created_at';
        }

        if ($order === null || $order === '') {
            $order = 'DESC';
        }

        $offset = ($page - 1) * $limit;
        $tableName = $this->tableName();
        try {
            $statement = $this->prepare("SELECT * FROM `$tableName` ORDER BY $sort $order LIMIT $limit OFFSET $offset");
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {
            return false;
        }

        return $result;
    }

    public function findOne($id)
    {
        $tableName = $this->tableName();
        $statement = $this->prepare("SELECT * FROM `$tableName` WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function find(string $table, array $where)
    {
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = $this->prepare("SELECT * FROM `$table` WHERE $sql ORDER BY created_at DESC");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = $this->prepare("INSERT INTO `$tableName` (" . implode(',', $attributes) . ")
        VALUES (" . implode(',', $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();

        return true;
    }

    public function update($id)
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
        $statement = $this->prepare("UPDATE `$tableName` SET " . implode(',', $params) . " WHERE id=:id");
        $statement->bindValue(':id', $id);
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();

        return true;
    }

    public function destroy($id)
    {
        $tableName = $this->tableName();
        $statement = $this->prepare("DELETE FROM `$tableName` WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();

        return true;
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            $pos = strpos($attribute, '_');
            if ($pos) {
                $table = substr($attribute, 0, $pos);
            }
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if ($ruleName === 'required' && !$value) {
                    $this->errors[] = "$attribute field is required";
                }
                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[] = "$attribute must be valid email";
                }
                if ($ruleName === 'exist' && !$this->find($table . 's', ['id' => $value])) {
                    $this->errors[] = "$table doesn't exist";
                }
            }
        }

        return empty($this->errors);
    }
}
