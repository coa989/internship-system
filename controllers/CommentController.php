<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Intern;
use app\models\Mentor;
use app\src\Request;
use app\src\Response;

class CommentController
{
    public Comment $comment;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->comment = new Comment();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function store()
    {
        $this->comment->loadData($this->request->getBody());
        $mentor = (new Mentor())->findOne($this->comment->mentor_id);
        $intern = (new Intern())->findOne($this->comment->intern_id);
        if ($mentor->group_id !== $intern->group_id) {
            return $this->response->json(403, 'Mentor and intern do not belong to the same group');
        };
        if ($this->comment->validate() && $this->comment->save()) {
            return $this->response->json(201, 'Successfully Created');
        }
        return $this->response->json(400,
            'Validation Failed',
            ['errors' => $this->comment->errors]);
    }
}