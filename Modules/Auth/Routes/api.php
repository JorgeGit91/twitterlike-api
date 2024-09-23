<?php

use Illuminate\Http\Request;
use Modules\Auth\Http\Controllers\Api\V1\AuthController;

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

Route::group(['prefix' => 'v1/auth', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/update', [AuthController::class, 'update']);
    Route::post('/delete/{user}', [AuthController::class, 'destroy']);
    Route::get('/logged', [AuthController::class, 'logged']);
});

Route::group(['prefix' => 'v1/auth', 'middleware' => []], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
