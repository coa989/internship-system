<?php

namespace app\controllers;

use app\models\Mentor;
use app\src\Controller;

class MentorController extends Controller
{
    public function __construct()
    {
        parent::__construct(Mentor::class);
    }

    public function show($id)
    {
        $mentor = $this->model->findOne($id);
        $group = $this->model->find('groups', ['id' => $mentor->group_id]);
        if (!$mentor) {
            return $this->response->json(404);
        }

        return $this->response->json(200, [
            'attributes' => $mentor,
            'group' =>$group
            ]);
    }

    public function store()
    {
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->save()) {
            return $this->response->json(201);
        }

        return $this->response->json(400, [
            'errors' => $this->model->errors
        ]);
    }

    public function update($id)
    {
        $mentor = $this->model->findOne($id);
        if (!$mentor) {
            return $this->response->json(404);
        }

        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->update($id)) {
            return $this->response->json(201);
        }

        return $this->response->json(400, [
            'errors' => $this->model->errors
        ]);
    }

    public function destroy($id)
    {
        $mentor = $this->model->findOne($id);
        if (!$mentor) {
            return $this->response->json(404);
        }

        if ($this->model->destroy($id)) {
            return $this->response->json(200);
        }
    }
}
