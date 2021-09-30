<?php

namespace app\src;

class Response
{
    public function json($code = 200, $data = null)
    {
        header_remove();
        http_response_code($code);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');
        $status = [
            200 => '200 OK',
            201 => '201 Created',
            400 => '400 Bad Request',
            403 => '403 Forbidden',
            404 => '404 Not Found'
        ];

        echo json_encode([
            'status' => $status[$code],
            'data' => $data,
        ]);
    }
}
