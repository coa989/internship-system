<?php

namespace app\src;

class Group extends Model
{
    private Request $request;
    public string $name = '';

    public function __construct()
    {
        $this->request = new Request();
    }

    public function show($id)
    {
        $group = $this->findOne($id);
        if (!$group) {
            http_response_code(404);
            echo 'Not Found!';
            exit();
        }
        $interns = $this->find('interns', ['group_id' => $id]);
        $mentors = $this->find('mentors', ['group_id' => $id]);
        echo json_encode([$group, 'interns' => $interns, 'mentors' => $mentors]);
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
        $group = $this->findOne($id);
        if (!$group) {
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
        $group = $this->findOne($id);
        if (!$group) {
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
        return 'groups';
    }

    public function attributes(): array
    {
        return ['name'];
    }

    public function rules(): array
    {
        return [
            'name' => ['required']
        ];
    }
}