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
        $input = $this->request->getBody();
        $allGroups = $this->model->getAll($input['limit'], $input['page'], $input['sort'], $input['order']);

        if (!$allGroups) {
            return $this->response->json(500, [
                'errors' => 'Incorrect input value'
            ]);
        }

        foreach ($allGroups as $group) {
            $group->mentors = $this->model->find('mentors', ['group_id' => $group->id]);
            $group->interns = $this->model->find('interns', ['group_id' => $group->id]);
            $groups[] = $group;
        }

        return $this->response->json(200, [
            $groups
        ]);
    }

    public function show($id)
    {
        $group = $this->model->findOne($id);
        if (!$group) {
            return $this->response->json(404);
        }

        $interns = $this->model->find('interns', ['group_id' => $id]);
        $mentors = $this->model->find('mentors', ['group_id' => $id]);

        return $this->response->json(200, [
            'attributes' => $group,
            'interns' => $interns,
            'mentors' => $mentors
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
        $group = $this->model->findOne($id);
        if (!$group) {
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
        $group = $this->model->findOne($id);
        if (!$group) {
            return $this->response->json(404);
        }

        if ($this->model->destroy($id)) {
            return $this->response->json(200);
        }
    }
}
