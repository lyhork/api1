<?php

use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/regulator',               [PublicController::class, 'regulator']);
Route::get('/regulator/{id}',          [PublicController::class, 'viewRegulator']);
Route::get('/survey-type',             [PublicController::class, 'surveyType']);

Route::get('/survey',                  [PublicController::class, 'survey']);
Route::get('/survey/{id}',             [PublicController::class, 'viewSurvey']);
Route::post('/regulator/{regulator_id}/type/{type_id}',           [PublicController::class, 'submitSurvey']);
Route::post('/save-survey/{regulator_id}/type/{type_id}',              [PublicController::class, 'submitSurvey']);
Route::post('/survey/{id}',            [PublicController::class, 'saveSurvey']);