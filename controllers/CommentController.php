<?php

namespace app\controllers;

use app\models\Comment;
use app\models\Intern;
use app\models\Mentor;
use app\src\Controller;

class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct(Comment::class);
    }

    public function store()
    {
        $this->model->loadData($this->request->getBody());
        $mentor = (new Mentor())->findOne($this->model->mentor_id);
        $intern = (new Intern())->findOne($this->model->intern_id);

        if (!$this->model->validate()) {
            echo $this->response->json(400, $this->model->errors);
        }

        if ($mentor->group_id !== $intern->group_id) {
            echo $this->response->json(403, ['Mentor and intern do not belong to the same group']);
        }

        $this->model->save();
        echo $this->response->json(201);
    }
}
