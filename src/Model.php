<?php

namespace app\src;

use app\db\Database;

abstract class Model extends Database
{
    public array $errors;

    abstract public function tableName(): string ;

    abstract public function attributes(): array ;

    abstract public function rules(): array;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getAll($orderBy = 'created_at', $limit = 25)
    {
        $tableName = $this->tableName();
        $statement = $this->prepare("SELECT * FROM `$tableName` ORDER BY $orderBy DESC LIMIT $limit");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function findOne($id)
    {
        $tableName = $this->tableName();
        if ($tableName === 'mentors' || $tableName === 'interns') {
            $statement = $this->prepare(
                "SELECT $tableName.first_name, $tableName.last_name, $tableName.email,
            $tableName.created_at, $tableName.updated_at, `groups`.name AS `group`
            FROM $tableName
            LEFT JOIN `groups`
            ON $tableName.group_id=`groups`.id
            WHERE $tableName.id=:id"
            );
        } else {
            $statement = $this->prepare("SELECT * FROM `$tableName` WHERE id=:id");
        }
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function find(string $table, array $where)
    {
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = $this->prepare("SELECT * FROM `$table` WHERE $sql");
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
        $statement = $this->prepare("INSERT INTO `$tableName` (".implode(',', $attributes).")
        VALUES (".implode(',', $params).")");
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
        $statement = $this->prepare("UPDATE `$tableName` SET ".implode(',', $params)." WHERE id=:id");
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
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if ($ruleName === 'required' && !$value) {
                    $this->errors[] = "$attribute field is required";
                }
                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[] = "$attribute must be valid email";
                }
                if ($ruleName === 'exist' && !$this->find('groups', ['id' => $value])) {
                    $this->errors[] = "group doesn't exist";
                }
            }
        }
        return empty($this->errors);
    }
}