<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\Api\ApiPostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthApiController::class, 'login']);
Route::middleware('auth:api')->post('refresh-token', [AuthApiController::class, 'refreshToken']);
Route::middleware('auth:api')->post('logout', [AuthApiController::class, 'logout']);

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::get('posts', [ApiPostController::class, 'index']);
    Route::post('posts', [ApiPostController::class, 'store']);
    Route::get('posts/{id}', [ApiPostController::class, 'show']);
    Route::put('posts/{id}', [ApiPostController::class, 'update']);
    Route::delete('posts/{id}', [ApiPostController::class, 'destroy']);
});
