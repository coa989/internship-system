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
        $comments = $this->model->find('comments', ['intern_id' => $intern->id]);
        if (!$intern) {
            return $this->response->json(404, 'Not Found');
        }
        return $this->response->json(200,
            'Successful',
            [$intern, 'comments' => $comments]);
    }

    public function store()
    {
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->save()) {
            return $this->response->json(201, 'Successfully Created');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->model->errors]);
    }

    public function update($id)
    {
        $intern = $this->model->findOne($id);
        if (!$intern) {
            return $this->response->json(404, 'Not Found');
        }
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->update($id)) {
            return $this->response->json(201, 'Successfully Updated');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->model->errors]);
    }

    public function destroy($id)
    {
        $intern = $this->model->findOne($id);
        if (!$intern) {
            return $this->response->json(404, 'Not Found');
        }
        if ($this->model->destroy($id)) {
            return $this->response->json(200, 'Successfully Deleted');
        }
    }
}