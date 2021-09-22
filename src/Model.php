<?php

namespace app\src;

use app\db\Database;

abstract class Model
{
    abstract public function tableName(): string ;

    public function prepare($statement)
    {
        return (new Database())->pdo->prepare($statement);
    }

    public function getAll()
    {
        $tableName = $this->tableName();
        $statement = $this->prepare("SELECT * FROM $tableName ORDER BY created_at DESC");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}