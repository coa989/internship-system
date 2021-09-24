<?php

namespace app\src;

class Response
{
    public function json($code, $message, $data = null)
    {
        header_remove();
        http_response_code($code);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');

        echo json_encode([
            'message' => $message,
            'data' => $data
        ]);
    }
}