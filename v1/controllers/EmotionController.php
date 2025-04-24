<?php
namespace Controllers;
use Core\Request;
use Services\EmotionService;

class EmotionController
{
    protected $request;
    protected $emotionService;

    public function __construct()
    {
        $this->request = new Request();
        $this->emotionService = new EmotionService();
    }

    public function getEmotions()
    {
        $this->emotionService->getAll();
    }

}