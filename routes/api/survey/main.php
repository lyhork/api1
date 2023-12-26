<?php

use App\Http\Controllers\Survey\SurveyController;
use App\Http\Controllers\Survey\SurveyTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/surveys',         [SurveyController::class, 'listing']);
Route::post('/surveys',        [SurveyController::class, 'create']);
Route::post('/surveys/{id}',   [SurveyController::class, 'update']);
Route::delete('/surveys/{id}', [SurveyController::class, 'delete']);

Route::get('/surveys/printing',         	[SurveyController::class, 'printReport']);


Route::group(['prefix' => 'survey'], function () {
    Route::get('/types',            [SurveyTypeController::class, 'listing']);
    Route::post('/types',           [SurveyTypeController::class, 'create']);
    Route::post('/types/{id}',      [SurveyTypeController::class, 'update']);
    Route::delete('/types/{id}',    [SurveyTypeController::class, 'delete']);
});
