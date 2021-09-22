<?php

namespace app\src;

use app\db\Database;

abstract class Model
{
    abstract public function tableName(): string ;

    public function index()
    {
        $tableName = $this->tableName();
        $statement = $this->prepare("SELECT * FROM $tableName ORDER BY created_at DESC");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function show($id)
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