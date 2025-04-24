<?php
namespace Services;
use Models\Emotion;
use Core\Response;

class EmotionService
{
    protected $model;
    protected $response;

    public function __construct()
    {
        $this->model = new Emotion();
        $this->response = new Response();
    }

    public function getAll()
    {
        //obtiene todas las emociones registradas
        $emotions = $this->model->all();
        if(!empty($emotions)){
            $this->response->success('Estas son las emociones registradas',['emotions' => $emotions]);
        }else{
            $this->response->success('Aun no hay registro de emociones');
        }
    }
}