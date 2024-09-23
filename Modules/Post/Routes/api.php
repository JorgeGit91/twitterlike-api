<?php

use Illuminate\Http\Request;

use Modules\Post\Http\Controllers\Api\V1\PostController;

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

Route::group(['prefix' => 'v1/post', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', [PostController::class, 'store']);
    Route::post('/update/{post}', [PostController::class, 'update']);
    Route::post('/delete/{post}', [PostController::class, 'destroy']);
    Route::get('/latest', [PostController::class, 'latest']);
    Route::get('/fuzzySearch/{string}', [PostController::class, 'fuzzySearch']);
    Route::get('/{post?}', [PostController::class, 'index']);
});
