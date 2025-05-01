<?php
namespace Controllers;
use Core\Request;
use Services\PhraseService;

class PhraseController
{
    protected $request;
    protected $userService;

    public function __construct()
    {
        $this->request = new Request();
        $this->phraseService = new PhraseService();
    }

    public function getPhrase()
    {
        $this->phraseService->getPhrase();
    }

}