<?php
use Core\Router;
use Controllers\UserController;

Router::post('/apimymood/v1/register',[UserController::class, 'registerUser']);
Router::post('/apimymood/v1/login',[UserController::class, 'login']);

Router::dispatch();