<?php

namespace app\src;

use app\db\Database;

abstract class Model
{
    abstract public function tableName(): string ;

    abstract public function attributes(): array ;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getAll()
    {
        $tableName = $this->tableName();
        $statement = $this->prepare("SELECT * FROM $tableName ORDER BY created_at DESC");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find($id)
    {
        $tableName = $this->tableName();
        $statement = $this->prepare(
            "SELECT $tableName.first_name, $tableName.last_name, $tableName.email, 
            $tableName.created_at, $tableName.updated_at, `groups`.name as group_name
            FROM $tableName 
            LEFT JOIN `groups` 
            ON $tableName.group_id=`groups`.id 
            WHERE $tableName.id=:id
        ");
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).")
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
        $statement = self::prepare("UPDATE $tableName SET ".implode(',', $params)." WHERE id=:id");
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
        $statement = $this->prepare("DELETE FROM $tableName WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();

        return true;
    }

    public function prepare($statement)
    {
        return (new Database())->pdo->prepare($statement);
    }
}