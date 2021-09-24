<?php

namespace app\src;

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
}