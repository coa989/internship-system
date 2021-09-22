<?php

namespace app\src;

use app\db\Database;

class Mentor
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        $statement = $this->db->pdo->prepare("SELECT * FROM mentors ORDER BY created_at DESC ");
        $statement->execute();
        return json_encode($statement->fetchAll(\PDO::FETCH_OBJ));
    }

    public function show($id)
    {
        $statement = $this->db->pdo->prepare("SELECT * FROM mentors WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return json_encode($statement->fetch(\PDO::FETCH_OBJ));
    }
}