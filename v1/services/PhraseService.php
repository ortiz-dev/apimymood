<?php
namespace Services;
use Models\Phrase;
use Models\DailyMood;
use Core\Response;
use Core\Auth;

class PhraseService
{
    protected $model;
    protected $response;
    protected $auth;

    public function __construct()
    {
        $this->model = new Phrase();
        $this->response = new Response();
        $this->auth = new Auth();
    }

   
    public function getPhrase()
    {
        //verifica autenticación
        $allow = $this->auth->isAuthenticated();
        if(!$allow){
            $this->response->error('Debe realizar la autenticación(login)');
        }

        $user_id = $allow->id;
        $date = date('Y-m-d');
        $dailyMood = new DailyMood();
        $response = $dailyMood->find($user_id, $date);
        if($response){
            $phrase = new Phrase();
            $phrase = $phrase->find($response['phrase_id']);
            $this->response->success('La frase para ti hoy es...',['phrase' => $phrase['phrase']]);
        }
        $this->response->error('Primero debe registrar su estado de ánimo el día de hoy');
    }

}