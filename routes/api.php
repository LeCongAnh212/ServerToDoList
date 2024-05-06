<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/authorization', [UserController::class, 'authorization']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/logout', [UserController::class, 'logout']);

    Route::group(['prefix' => 'tasks'], function () {
        Route::get('/data', [TaskController::class, 'getData']);
        Route::post('/create', [TaskController::class, 'create']);
        Route::post('/delete', [TaskController::class, 'detele']);
        Route::post('/update', [TaskController::class, 'update']);

        Route::get('/data-finished', [TaskController::class, 'getDataFinished']);
        Route::get('/data-unfinished', [TaskController::class, 'getDataUnFinished']);
        Route::get('/data-out-date', [TaskController::class, 'getDataOutDate']);
    });


    Route::get('/type-task', [TaskController::class, 'getTypeTask']);
});
