<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([], function () {
    //============>>  Auth
    Route::group(['prefix' => 'auth'], function () {
        require(__DIR__ . '/api/auth/main.php');
    });
    //============>>  Authenticated
    Route::group(['middleware' => ['jwt.verify']], function () {

        //============>>  Dashboard
        require(__DIR__ . '/api/dashboard/main.php');

        //============>>  Regulator
        require(__DIR__ . '/api/regulator/main.php');

        //============>>  Survey
        require(__DIR__ . '/api/survey/main.php');

        //============>>  User
        require(__DIR__ . '/api/user/main.php');

        //============>> My Profile
        require(__DIR__ . '/api/myprofile/main.php');
    });
    //============>>  No Authenticated
    Route::group(['prefix' => 'public'], function () {
        require(__DIR__ . '/api/public/mian.php');
    });
});
