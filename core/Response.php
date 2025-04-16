<?php
namespace Core;

class Response
{
    protected $statusCode = 200;
    protected $headers = [
        'Content-Type' => 'application/json'
    ];

    public function setStatus($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    protected function json($data)
    {
        http_response_code($this->statusCode);
        foreach($this->headers as $key => $value){
            header("$key: $value");
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function success($message = 'OK', $data = [])
    {
        $this->json(array_merge([
                'success' => true,
                'message' => $message
        ], $data));
    }

    public function error($message = 'Error', $code = 400, $extra = [])
    {
        $this->setStatus($code)->json(array_merge([
            'success' => false,
            'message' => $message
        ], $extra));
    }
}