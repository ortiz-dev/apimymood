<?php
namespace Controllers;
use Core\Request;
use Services\UserService;

class UserController
{
    protected $request;
    protected $userService;

    public function __construct()
    {
        $this->request = new Request();
        $this->userService = new UserService();
    }

    public function registerUser()
    {
        $data = json_decode($this->request->rawBody(), true);
        $this->userService->register($data);
    }
}