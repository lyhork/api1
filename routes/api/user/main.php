<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/users', 						[UserController::class, 'listing']);
Route::get('/users/{id}', 					[UserController::class, 'view']);
Route::post('/users', 						[UserController::class, 'create']);
Route::post('/users/{id}', 					[UserController::class, 'update']);
Route::delete('/users/{id}', 				[UserController::class, 'delete']);
Route::post('/users/{id}/change-password',  [UserController::class, 'changePassword']);
Route::post('/users/{id}/change-status',    [UserController::class, 'updateStatus']);
Route::group(['prefix' => 'user'],function (){
    Route::get('/get-type',                     [UserController::class, 'getType']);
    Route::get('/get-regulator',                [UserController::class, 'getRegulator']);
});