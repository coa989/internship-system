<?php

namespace app\src;

use app\db\Database;

class Group extends Model
{
    private Validator $validate;
    private array $rules = [
        'name' => ['required']
    ];
    public string $name = '';

    public function __construct()
    {
        $this->validate = new Validator($this->rules, $this->getBody());
    }

    public function show($id)
    {
        $group = parent::findOne($id);
        if (!$group) {
            http_response_code(404);
            echo 'Not Found!';
            exit();
        }
        $interns = parent::find('interns', ['group_id' => $id]);
        $mentors = parent::find('mentors', ['group_id' => $id]);
        echo json_encode([$group, 'interns' => $interns, 'mentors' => $mentors]);
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
            parent::loadData($this->getBody());
            if (parent::update($id)) {
                http_response_code(200);
                echo 'Success';
            }
        }

        foreach ($this->validate->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function destroy($id)
    {
        $intern = parent::findOne($id);
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
        return 'groups';
    }

    public function attributes(): array
    {
        return ['name'];
    }
}