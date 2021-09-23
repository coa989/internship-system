<?php

namespace app\src;

class Mentor extends Model
{
    private Request $request;
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
        $this->request = new Request();
        $this->validate = new Validator($this->rules, $this->request->getBody());
    }

    public function index()
    {
        echo json_encode(parent::getAll());
    }

    public function show($id)
    {
        $mentor = parent::findOne($id);
        if (!$mentor) {
            http_response_code(404);
            echo 'Not Found';
            exit();
        }

        echo json_encode($mentor);
    }

    public function store()
    {
        if ($this->validate->handle()) {
            parent::loadData($this->request->getBody());
            if (parent::save()) {
                http_response_code(201);
                echo 'Success';
                exit();
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
            parent::loadData($this->request->getBody());
            if (parent::update($id)) {
                http_response_code(200);
                echo 'Success';
                exit();
            }
        }

        foreach ($this->validate->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function destroy($id)
    {
        $mentor = parent::findOne($id);
        if (!$mentor) {
            http_response_code(404);
            echo 'Not Found';
            exit();
        }

        parent::destroy($id);
        http_response_code(200);
        echo 'Success';
    }

    public function tableName(): string
    {
        return 'mentors';
    }

    public function attributes(): array
    {
        return ['first_name', 'last_name', 'email', 'group_id'];
    }
}