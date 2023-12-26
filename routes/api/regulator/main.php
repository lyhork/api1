<?php

use App\Http\Controllers\Regulator\RegulatorController;
use Illuminate\Support\Facades\Route;

Route::get('/regulators',         [RegulatorController::class, 'listing']);
Route::get('/regulators/{id}', 	  [RegulatorController::class, 'view']);
Route::post('/regulators',        [RegulatorController::class, 'create']);
Route::post('/regulators/{id}',   [RegulatorController::class, 'update']);
Route::post('/regulators/{id}/change-status',    [RegulatorController::class, 'updateStatus']);
Route::delete('/regulators/{id}', [RegulatorController::class, 'delete']);

