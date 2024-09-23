<?php

use Illuminate\Http\Request;

use Modules\Comment\Http\Controllers\Api\V1\CommentController;
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

Route::group(['prefix' => 'v1/comment', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create', [CommentController::class, 'store']);
    Route::post('/update/{comment}', [CommentController::class, 'update']);
    Route::post('/delete/{comment}', [CommentController::class, 'destroy']);
    Route::get('/', [CommentController::class, 'index']);
});