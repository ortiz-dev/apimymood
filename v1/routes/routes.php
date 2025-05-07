<?php
use Core\Router;
use Controllers\UserController;
use Controllers\DailyMoodController;
use Controllers\PhraseController;

Router::post('/apimymood/v1/register',[UserController::class, 'registerUser']);
Router::post('/apimymood/v1/login',[UserController::class, 'login']);
Router::post('/apimymood/v1/moods',[DailyMoodController::class, 'registerDailyMood']);
Router::get('/apimymood/v1/phrases/today',[PhraseController::class, 'getPhrase']);
Router::get('/apimymood/v1/moods/summary',[DailyMoodController::class, 'getSummaryWeek']);

Router::dispatch();