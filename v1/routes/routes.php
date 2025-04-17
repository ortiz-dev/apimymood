<?php
use Core\Router;
use Controllers\UserController;

Router::post('/apimymood/v1/register',[UserController::class, 'registerUser']);

Router::dispatch();