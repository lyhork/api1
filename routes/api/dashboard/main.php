<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'getInfo']);
Route::get('/dashboard/chart-data', [DashboardController::class, 'getDataChart']);