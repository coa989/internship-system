<?php

namespace app\controllers;

use app\models\Mentor;
use app\src\Request;
use app\src\Response;

class MentorController
{
    public Mentor $mentor;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->mentor = new Mentor();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function show($id)
    {
        $mentor = $this->mentor->findOne($id);
        if (!$mentor) {
            return $this->response->json(404, 'Not Found');
        }
        return $this->response->json(200, 'Successful', $mentor);
    }

    public function store()
    {
        $this->mentor->loadData($this->request->getBody());
        if ($this->mentor->validate() && $this->mentor->save()) {
            return $this->response->json(201, 'Successfully Created');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->mentor->errors]);
    }

    public function update($id)
    {
        $mentor = $this->mentor->findOne($id);
        if (!$mentor) {
            return $this->response->json(404, 'Not Found');
        }
        $this->mentor->loadData($this->request->getBody());
        if ($this->mentor->validate() && $this->mentor->update($id)) {
            return $this->response->json(201, 'Successfully Updated');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->mentor->errors]);
    }

    public function destroy($id)
    {
        $mentor = $this->mentor->findOne($id);
        if (!$mentor) {
            return $this->response->json(404, 'Not Found');
        }
        if ($this->mentor->destroy($id)) {
            return $this->response->json(200, 'Successfully Deleted');
        }
    }
}