<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');




Route::group(['prefix' => 'projects', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('add', [ProjectController::class, 'add']);
    Route::get('edit/{id}', [ProjectController::class, 'edit']);
    Route::post('update/{id}', [ProjectController::class, 'update']);
    Route::delete('delete/{id}', [ProjectController::class, 'delete']);
});



Route::group(['prefix' => 'statuses', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [StatusController::class, 'index']);
    Route::post('add', [StatusController::class, 'add']);
    Route::get('edit/{id}', [StatusController::class, 'edit']);
    Route::post('update/{id}', [StatusController::class, 'update']);
    Route::delete('delete/{id}', [StatusController::class, 'delete']);
});


Route::group(['prefix' => 'tasks', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/tasks_title', [TaskController::class, 'tasks_title']);
    Route::post('add', [TaskController::class, 'add']);
    Route::get('edit/{id}', [TaskController::class, 'edit']);
    Route::post('update/{id}', [TaskController::class, 'update']);
    Route::delete('delete/{id}', [TaskController::class, 'delete']);
});

Route::group(['prefix' => 'users', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [UserController::class, 'index']);
});
Route::post('demos/tasks/{id}', [TaskController::class, 'updateTasksStatus'])->middleware('auth:sanctum');

