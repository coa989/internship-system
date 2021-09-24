<?php

namespace app\src;

class Mentor extends Model
{
    private Request $request;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $group_id = '';

    public function __construct()
    {
        $this->request = new Request();
    }

    public function index()
    {
        echo json_encode($this->getAll());
    }

    public function show($id)
    {
        $mentor = $this->findOne($id);
        if (!$mentor) {
            http_response_code(404);
            echo 'Not Found';
            exit();
        }

        echo json_encode($mentor);
    }

    public function store()
    {
        $this->loadData($this->request->getBody());
        if ($this->validate()) {
            if ($this->save()) {
                http_response_code(201);
                echo 'Success';
                exit();
            }
        }

        foreach ($this->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function update($id)
    {
        $mentor = $this->findOne($id);
        if (!$mentor) {
            http_response_code(404);
            echo 'Not Found';
            exit();
        }

        $this->loadData($this->request->getBody());
        if ($this->validate()) {
            if (parent::update($id)) {
                http_response_code(200);
                echo 'Success';
                exit();
            }
        }

        foreach ($this->errors as $error) {
            http_response_code(400);
            echo $error . "\n";
        }
    }

    public function destroy($id)
    {
        $mentor = $this->findOne($id);
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

    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'group_id' => ['required'],
        ];
    }
}