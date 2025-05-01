<?php
namespace Services;
use Models\DailyMood;
use Models\Mood;
use Models\Phrase;
use Core\Response;
use Core\Auth;

class DailyMoodService
{
    protected $model;
    protected $response;
    protected $auth;

    public function __construct()
    {
        $this->model = new DailyMood();
        $this->response = new Response();
        $this->auth = new Auth();
    }

    public function register($data)
    {
        //verifica autenticación
        $allow = $this->auth->isAuthenticated();
        if(!$allow){
            $this->response->error('Debe realizar la autenticación(login)');
        }

        //validar
        $data['daily_date'] = date('Y-m-d');
        $data['user_id'] = $allow->id;
        $this->validateData($data);

        //verificar si ya existe el registro del dia
        $existing = $this->getMoodToday($data);
        $objPhrase = new Phrase();
        if($existing){
            //obtener la frase
            $phrase = $objPhrase->find($existing['phrase_id']);
            unset($existing['phrase_id']);
            $existing['phrase'] = $phrase;
            $this->response->error('Ya se registro el estado de ánimo del día', 400, ['daily_mood' => $existing]);
        }

        //crear el registro del estado de ánimo
        $data['state'] = trim(strtolower($data['state']));
        $keyWords = $this->searchKeyWords($data['state']);
        if(!$keyWords){
            $keyWords = $this->getMoodDefault();
        }
        $data['phrase_id'] = $this->getPhraseId($keyWords);
        if(!$data['phrase_id']){
            $this->response->error('No se ha efectuado el registro del estado de ánimo');
        }
        //obtener frase a mostrar
        $phrase = $objPhrase->find($data['phrase_id']);
        $phrase = $phrase['phrase'];
        if($this->model->create($data) > 0){
            $this->response->success('Se registro el estado de ánimo correctamente',['phrase' => $phrase]);
        }else{
            $this->response->error('No se ha efectuado el registro del estado de ánimo');
        }
    }

    private function validateData($data)
    {
        if(empty($data['state'])){
            $this->response->error('No se ingreso el dato requerido', 400, ['formato_esperado' => ['state' => 'hoy me siento feliz']]);
        }
    }

    private function getMoodToday($data)
    {
        $existing = $this->model->find($data['user_id'], $data['daily_date']);
        return $existing;
    }

    private function getPhraseId($ids_mood){
        $phrase = new Phrase();
        $phrases = $phrase->filter($ids_mood);
        if($phrases){
            $index = rand(1,count($phrases));
            return $phrases[$index]['phrase_id'];
        }
        return null;
    }

    private function searchKeyWords($state){
        $words = explode(' ',$state);
        $words = array_filter($words, fn($word) => strlen($word)>2);
        $mood = new Mood();
        return $mood->filter($words);
    }

    private function getMoodDefault()
    {
        $data = [];
        array_push($data, 'otra');
        $mood = new Mood();
        return $mood->filter($data);;
    }

}