<?php

namespace app\src;

use app\db\Database;

class Mentor extends Model
{
    private Database $db;
    private Validator $validate;
    private array $rules = [
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required', 'email'],
        'group_id' => ['required'],
    ];

    public function __construct()
    {
        $this->db = new Database();
        $this->validate = new Validator($this->rules, $this->getBody());
    }

    public function index()
    {
        echo json_encode(parent::getAll());
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
        if ($this->validate->handle()) {
            $statement = $this->db->pdo->prepare("INSERT INTO mentors (first_name, last_name, email, group_id) VALUES (:first_name, :last_name, :email, :group_id)");
            $statement->bindValue(':first_name', $_POST['first_name']);
            $statement->bindValue(':last_name', $_POST['last_name']);
            $statement->bindValue(':email', $_POST['email']);
            $statement->bindValue(':group_id', $_POST['group_id']);
            $statement->execute();

            http_response_code(201);
            echo 'Success';
        }

        foreach ($this->validate->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function update($id)
    {
        if ($this->validate->handle()) {
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

        foreach ($this->validate->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function destroy($id)
    {
        $statement = $this->db->pdo->prepare("DELETE FROM mentors WHERE id=:id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        return true;
    }

    public function getBody()
    {
        $body = [];

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function tableName(): string
    {
        return 'mentors';
    }
}