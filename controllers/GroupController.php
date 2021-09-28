<?php

namespace app\controllers;

use app\models\Group;
use app\models\Intern;
use app\models\Mentor;
use app\src\Controller;

class GroupController extends Controller
{

    public function __construct()
    {
        parent::__construct(Group::class);
    }

    public function index()
    {
        $groups = $this->model->getAll('created_at', 3);
        $mentors = (new Mentor())->getAll('first_name', 10);
        $interns = (new Intern())->getAll('first_name', 10);
        return $this->response->json(200, 'Successfull', [
            'groups' => $groups,
            'mentors' => $mentors,
            'interns' => $interns
        ]);
    }

    public function show($id)
    {
        $group = $this->model->findOne($id);
        if (!$group) {
            return $this->response->json(404, 'Not Found');
        }
        $interns = $this->model->find('interns', ['group_id' => $id]);
        $mentors = $this->model->find('mentors', ['group_id' => $id]);
        return $this->response->json(200, 'Successful', [
            'group' => $group,
            'interns' => $interns,
            'mentors' => $mentors
        ]);
    }

    public function store()
    {
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->save()) {
            return $this->response->json(201, 'Successfully Created');
        }
        return $this->response->json(
            400,
            'Validation Failed',
            ['errors' => $this->model->errors]
        );
    }

    public function update($id)
    {
        $group = $this->model->findOne($id);
        if (!$group) {
            return $this->response->json(404, 'Not Found');
        }
        $this->model->loadData($this->request->getBody());
        if ($this->model->validate() && $this->model->update($id)) {
            return $this->response->json(201, 'Successfully Updated');
        }
        return $this->response->json(
            400,
            'Validation Failed',
            ['errors' => $this->model->errors]
        );
    }

    public function destroy($id)
    {
        $group = $this->model->findOne($id);
        if (!$group) {
            return $this->response->json(404, 'Not Found');
        }
        if ($this->model->destroy($id)) {
            return $this->response->json(200, 'Successfully Deleted');
        }
    }
}
