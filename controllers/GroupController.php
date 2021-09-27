<?php

namespace app\controllers;

use app\src\Group;
use app\src\Request;
use app\src\Response;

class GroupController
{
    public Group $group;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->group = new Group();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function show($id)
    {
        $group = $this->group->findOne($id);
        if (!$group) {
            return $this->response->json(404, 'Not Found');
        }
        $interns = $this->group->find('interns', ['group_id' => $id]);
        $mentors = $this->group->find('mentors', ['group_id' => $id]);
        return $this->response->json(200, 'Successful', [
            'group' => $group,
            'interns' => $interns,
            'mentors' => $mentors
        ]);
    }

    public function store()
    {
        $this->group->loadData($this->request->getBody());
        if ($this->group->validate() && $this->group->save()) {
            return $this->response->json(201, 'Successfully Created');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->group->errors]);
    }

    public function update($id)
    {
        $group = $this->group->findOne($id);
        if (!$group) {
            return $this->response->json(404, 'Not Found');
        }
        $this->group->loadData($this->request->getBody());
        if ($this->group->validate() && $this->group->update($id)) {
            return $this->response->json(201, 'Successfully Updated');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->group->errors]);
    }

    public function destroy($id)
    {
        $group = $this->group->findOne($id);
        if (!$group) {
            return $this->response->json(404, 'Not Found');
        }
        if ($this->group->destroy($id)) {
            return $this->response->json(200, 'Successfully Deleted');
        }
    }
}