<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login',                   [AuthController::class, 'login']);
Route::post('/logout',                  [AuthController::class, 'logout']);
Route::post('/refresh',                 [AuthController::class, 'refresh']);
