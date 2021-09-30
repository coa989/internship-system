<?php

namespace app\controllers;

use app\models\Intern;
use app\src\Controller;

class InternController extends Controller
{
    public function __construct()
    {
        parent::__construct(Intern::class);
    }

    public function show($id)
    {
        $intern = $this->model->findOne($id);
        $group = $this->model->find('groups', ['id' => $intern->group_id]);
        $comments = $this->model->find('comments', ['intern_id' => $intern->id]);

        if (!$intern) {
            echo $this->response->json(404);
        }

        echo $this->response->json(200, [
            'attributes' => $intern,
            'group' => $group,
            'comments' => $comments
        ]);
    }

    public function store()
    {
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->save()) {
            echo $this->response->json(201);
        }
        echo $this->response->json(400, $this->model->errors);
    }

    public function update($id)
    {
        $intern = $this->model->findOne($id);
        if (!$intern) {
            echo $this->response->json(404);
        }
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->update($id)) {
            echo $this->response->json(201);
        }
        echo $this->response->json(400, $this->model->errors);
    }

    public function destroy($id)
    {
        $intern = $this->model->findOne($id);
        if (!$intern) {
            echo $this->response->json(404);
        }
        if ($this->model->destroy($id)) {
            echo $this->response->json(200);
        }
    }
}
