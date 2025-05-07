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
        $keyWord = $this->getKeyWord($data['state']);
        $data['phrase_id'] = $this->getPhraseId($keyWord['mood_id']);
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

    private function getPhraseId($mood_id){
        $phrase = new Phrase();
        $mood_phrases = $phrase->filter('mood_id', $mood_id);
        if($mood_phrases){
            $index = rand(1,count($mood_phrases));
            return $mood_phrases[$index]['phrase_id'];
        }
        return null;
    }

    private function getKeyWord($state){
        $mood = new Mood();
        $moods = $mood->getAll();
        $words = explode(' ', $state);
        $default = [];
        
        foreach($words as $word){
            foreach($moods as $mood){
                if(strpos(str_replace(',', ' ', $mood['emotion']).' ', $word.' ') !== false){
                    return ['mood_id' => $mood['id'], 'emotion' => $word];
                }
                if(strpos(str_replace(',', ' ', $mood['emotion']).' ', 'neutral ') !== false){
                    $default['mood_id'] = $mood['id'];
                    $default['emotion'] = 'neutral';
                }
            }
        }
        return $default;
    }

    public function getSummaryWeek()
    {
        //verifica autenticación
        $allow = $this->auth->isAuthenticated();
        if(!$allow){
            $this->response->error('Debe realizar la autenticación(login)');
        }

        $id_user = $allow->id;
        $weekData = $this->model->filterWeek($id_user);
        if($weekData){
            $response = $this->getCountMood($weekData);
            $emotions = $response['emotions'];
            $mood = $this->getMaxEmotion($emotions);
            $this->response->success('Resumen del estado de ánimo de la semana',['summary_week' => $weekData, 'frequency' => $response['week'], 'dominant_state' => $mood]);
        }
        $this->response->error('Aún no hay registros de estado de ánimo de esta semana');
    }

    private function getCountMood($weekData){
        $emotions = [];
        $week = [];
        foreach($weekData as $day){
            $emotion = $this->getKeyWord($day['state']);
            $week[$day['day']] = $emotion['emotion'];
            if(array_key_exists($emotion['emotion'], $emotions)){
                $emotions[$emotion['emotion']] +=1;
            }else{
                $emotions[$emotion['emotion']] = 1;
            }
        }
        return  ['week' => $week, 'emotions' => $emotions];
    }

    private function getMaxEmotion($emotions)
    {
        $mood = 'variante';
        $countMood = 0;
        foreach($emotions as $emotion => $count){
            if($count == 4){
                $mood = $emotion;
                return $mood;
            }
            else if($count == 3 && $count >= $countMood){
                if($mood!='variante' && $countMood == $count){
                     $mood .=' y '.$emotion;
                     return $mood;
                }
                $countMood = $count;
                $mood = $emotion;
            }
            else if($count == 2 && $count >= $countMood){
                if($mood!='variante' && $countMood == $count){
                    $mood .=' y '.$emotion;
                }else{
                    $mood = $emotion;
                    $countMood = $count;
                }
            }
        }

        if(substr_count($mood, ' y ') == 2){
            $mood = 'variante';
        }
                
        return $mood;
    }
}