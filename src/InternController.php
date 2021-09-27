<?php


namespace app\src;


class InternController
{
    public Intern $intern;
    public Request $request;
    public Response $response;

    public function __construct()
    {
        $this->intern = new Intern();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function show($id)
    {
        $intern = $this->intern->findOne($id);
        if (!$intern) {
            return $this->response->json(404, 'Not Found');
        }
        return $this->response->json(200, 'Successful', $intern);
    }

    public function store()
    {
        $this->intern->loadData($this->request->getBody());
        if ($this->intern->validate() && $this->intern->save()) {
            return $this->response->json(201, 'Successfully Created');
        }
        return $this->response->json(400, 'Validation Failed', ['errors' => $this->intern->errors]);
    }

    public function update($id)
    {
        $intern = $this->intern->findOne($id);
        if (!$intern) {
            return $this->response->json(404, 'Not Found');
        }
        $this->intern->loadData($this->request->getBody());
        if ($this->intern->validate() && $this->intern->update($id)) {
            return $this->response->json(201, 'Successfully Updated');
        }
        return $this->response->json(400, 'Validation Failed', ['errors' => $this->intern->errors]);
    }

    public function destroy($id)
    {
        $intern = $this->intern->findOne($id);
        if (!$intern) {
            return $this->response->json(404, 'Not Found');
        }
        if ($this->intern->destroy($id)) {
            return $this->response->json(200, 'Successfully Deleted');
        }
    }
}