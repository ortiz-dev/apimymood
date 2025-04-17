<?php
namespace Services;
use Models\User;
use Core\Response;

class UserService
{
    protected $model;
    protected $response;

    public function __construct()
    {
        $this->model = new User();
        $this->response = new Response();
    }

    public function register($data)
    {
        //validar
        if(empty($data['username']) || empty($data['password'])){
            $this->response->error('Los datos estan incompletos', 400, ['formato_esperado' => ['username' => 'pepito@correo.com', 'password' => 'Miclave1234']]);
        }

        //verificar si existe
        $name = [];
        $data['username'] = strtolower($data['username']);
        $name['username'] = $data['username'];
        $existing = $this->model->filter($name);
        if($existing){
            $this->response->error('El usuario '.$data['username'].' ya esta registrado');
        }

        //crear usuario
        if($this->model->create($data) > 0){
            $this->response->success('El usuario se registro correctamente',['id' => $this->model->lastId()]);
        }else{
            $this->response->error('No se ha efectuado el registro del usuario');
        }
    }
}