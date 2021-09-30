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
        $groups = $this->model->getAll($input['limit'], $input['page'], $input['sort'], $input['order']);
        $mentors = (new Mentor())->getAll($input['limit'], $input['page'], $input['sort'], $input['order']);
        $interns = (new Intern())->getAll($input['limit'], $input['page'], $input['sort'], $input['order']);

        return $this->response->json(200, [
            'groups' => $groups,
            'mentors' => $mentors,
            'interns' => $interns
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
            'group' => $group,
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

        return $this->response->json(400, $this->model->errors);
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
        return $this->response->json(400, $this->model->errors);
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
