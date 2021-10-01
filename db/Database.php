<?php

namespace app\db;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $conn = $_ENV['DB_CONNECTION'];
        $host = $_ENV['DB_HOST'];
        $name = $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $this->pdo = new \PDO($conn . ':host=' . $host . ';dbname=' . $name, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    protected function prepare($statement)
    {
        return $this->pdo->prepare($statement);
    }
}
