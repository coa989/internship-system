<?php

namespace app\src;

class Controller
{
    protected Model $model;
    protected Request $request;
    protected Response $response;

    public function __construct($model)
    {
        $this->model = new $model();
        $this->request = new Request();
        $this->response = new Response();
    }
}
