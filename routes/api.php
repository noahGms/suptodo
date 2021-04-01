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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::get('whoami', [\App\Http\Controllers\AuthController::class, 'whoami'])->middleware(['auth:sanctum'])->name('whoami');
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('logout');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('todolists/{todolist}/items/{item}/status', [\App\Http\Controllers\TodoitemController::class, 'changeStatus']);
    Route::post('todolists/{todolist}/completeAll', [\App\Http\Controllers\TodoitemController::class, 'completeAll']);
    Route::post('todolists/{todolist}/incompleteAll', [\App\Http\Controllers\TodoitemController::class, 'incompleteAll']);
    Route::post('todolists/{todolist}/removeAllCompleted', [\App\Http\Controllers\TodoitemController::class, 'removeAllCompleted']);
    Route::apiResource('todolists/{todolist}/items', \App\Http\Controllers\TodoitemController::class);
    Route::post('todolists/{todolist}/accept', [\App\Http\Controllers\TodolistController::class, 'acceptParticipant']);
    Route::post('todolists/{todolist}/deny', [\App\Http\Controllers\TodolistController::class, 'denyParticipant']);
    Route::get('todolists/invitations', [\App\Http\Controllers\TodolistController::class, 'invitations']);
    Route::get('todolists/all', [\App\Http\Controllers\TodolistController::class, 'all']);
    Route::apiResource('todolists', \App\Http\Controllers\TodolistController::class);

    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);

    Route::get('friends/', [\App\Http\Controllers\FriendController::class, 'index']);
    Route::get('friends/invitations', [\App\Http\Controllers\FriendController::class, 'invitations']);
    Route::post('friends/', [\App\Http\Controllers\FriendController::class, 'add']);
    Route::delete('friends/{friend}', [\App\Http\Controllers\FriendController::class, 'remove']);
    Route::post('friends/{user}/accept', [\App\Http\Controllers\FriendController::class, 'accept']);
    Route::post('friends/{user}/deny', [\App\Http\Controllers\FriendController::class, 'deny']);
});

Route::post('/files/upload', [\App\Http\Controllers\FileController::class, 'upload']);
