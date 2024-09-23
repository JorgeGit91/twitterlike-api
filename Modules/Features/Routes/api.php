<?php

use Illuminate\Http\Request;
use Modules\Features\Http\Controllers\Api\V1\LikeController;
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

Route::group(['prefix' => 'v1/like', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/create/{post}', [LikeController::class, 'store']);
});