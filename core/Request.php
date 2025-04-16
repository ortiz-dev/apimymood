<?php
namespace Core;

class Request
{
    protected $method;
    protected $uri;
    protected $headers;
    protected $body;
    protected $json;
    protected $queryParams;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->headers = getallheaders();
        $this->queryParams = $_GET;
        $this->body = file_get_contents('php://input');
        $this->parseJson();
    }

    protected function parseJson()
    {
        if($this->isJson()){
            $decoded = json_decode($this->body, true);
            $this->json = is_array($decoded) ? $decoded : [];
        }else{
            $this->json = [];
        }
    }

    public function isJson()
    {
        return isset($this->headers['Content-Type']) && strpos($this->headers['Content-Type'], 'application/json') !== false;
    }

    public function method()
    {
        return $this->method;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function header($key)
    {
        return $this->headers[$key] ?? null;
    }

    public function query($key = null, $default = null)
    {
        return $key ? ($this->queryParams[$key] ?? $default) : $this->json;
    }

    public function rawBody()
    {
        return $this->body;
    }

    public function all()
    {
        return array_merge($this->queryParams, $this->json);
    }

}