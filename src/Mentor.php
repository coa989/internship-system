<?php

namespace app\src;

use app\db\Database;

class Mentor
{
    private Database $db;
    private array $attributes = ['first_name', 'last_name', 'email', 'group_id'];

    public function __construct()
    {
        $this->db = new Database();
    }

    public function index()
    {
        $statement = $this->db->pdo->prepare("SELECT * FROM mentors ORDER BY created_at DESC ");
        $statement->execute();
        echo json_encode($statement->fetchAll(\PDO::FETCH_OBJ));
    }

    public function show($id)
    {
        $statement = $this->db->pdo->prepare(
"SELECT first_name, last_name, email, created_at, updated_at, 
            `groups`.name as group_name
            FROM mentors 
            LEFT JOIN `groups`  
            on mentors.group_id = `groups`.id
            WHERE mentors.id = :id"
        );
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);

        if (!$result) {
            http_response_code(404);
            echo 'Not Found!';
            die();
        }

        echo json_encode($result);
    }

    public function store()
    {
        // todo validate data
        $statement = $this->db->pdo->prepare("INSERT INTO mentors (first_name, last_name, email, group_id) VALUES (:first_name, :last_name, :email, :group_id)");
        $statement->bindValue(':first_name', $_POST['first_name']);
        $statement->bindValue(':last_name', $_POST['last_name']);
        $statement->bindValue(':email', $_POST['email']);
        $statement->bindValue(':group_id', $_POST['group_id']);
        $statement->execute();

        http_response_code(201);

        echo 'Success';
    }

    public function update($id)
    {
        // todo validate data
        $statement = $this->db->pdo->prepare("UPDATE mentors SET first_name=:first_name, last_name=:last_name, email=:email, group_id=:group_id WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->bindValue(':first_name', $_POST['first_name']);
        $statement->bindValue(':last_name', $_POST['last_name']);
        $statement->bindValue(':email', $_POST['email']);
        $statement->bindValue(':group_id', $_POST['group_id']);
        $statement->execute();

        http_response_code(200);

        echo 'Success';
    }

    public function destroy($id)
    {
        $statement = $this->db->pdo->prepare("DELETE FROM mentors WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return true;
    }
}