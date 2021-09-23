<?php

namespace app\src;

use app\db\Database;

class Intern extends Model
{
    private Database $db;
    private Validator $validate;
    private array $rules = [
        'first_name' => ['required'],
        'last_name' => ['required'],
        'email' => ['required', 'email'],
        'group_id' => ['required'],
    ];
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public int $group_id;

    public function __construct()
    {
        $this->db = new Database();
        $this->validate = new Validator($this->rules, $this->getBody());
    }

    public function index()
    {
        echo json_encode(parent::index());
    }

    public function show($id)
    {
        $intern = parent::find($id);
        if (!$intern) {
            http_response_code(404);
            echo 'Not Found';
            exit();
        }

        echo json_encode($intern);
    }

    public function store()
    {
        if ($this->validate->handle()) {
            parent::loadData($this->getBody());
            if (parent::save()) {
                http_response_code(201);
                echo 'Success';
            }
        }

        foreach ($this->validate->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function update($id)
    {
        if ($this->validate->handle()) {
            $statement = $this->db->pdo->prepare("UPDATE interns SET first_name=:first_name, last_name=:last_name, email=:email, group_id=:group_id WHERE id=:id");
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
        $intern = parent::find($id);
        if (!$intern) {
            http_response_code(404);
            echo 'Not Found';
            exit();
        }

        parent::destroy($id);
        http_response_code(200);
        echo 'Success';
    }

    private function getBody()
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
        return 'interns';
    }

    public function attributes(): array
    {
        return ['first_name', 'last_name', 'email', 'group_id'];
    }
}