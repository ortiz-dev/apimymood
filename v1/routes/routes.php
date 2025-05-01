<?php
use Core\Router;
use Controllers\UserController;
use Controllers\DailyMoodController;

Router::post('/apimymood/v1/register',[UserController::class, 'registerUser']);
Router::post('/apimymood/v1/login',[UserController::class, 'login']);
Router::post('/apimymood/v1/moods',[DailyMoodController::class, 'registerDailyMood']);

Router::dispatch();