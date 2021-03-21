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
    Route::apiResource('todolists/{todolist}/items', \App\Http\Controllers\TodoitemController::class);
    Route::get('todolists/{todolist}/users/{user}/accept', [\App\Http\Controllers\TodolistController::class, 'acceptParticipant']);
    Route::get('todolists/{todolist}/users/{user}/deny', [\App\Http\Controllers\TodolistController::class, 'denyParticipant']);
   Route::apiResource('todolists', \App\Http\Controllers\TodolistController::class);

    Route::get('friends/', [\App\Http\Controllers\FriendController::class, 'index']);
    Route::get('friends/invitations', [\App\Http\Controllers\FriendController::class, 'invitations']);
    Route::post('friends/', [\App\Http\Controllers\FriendController::class, 'add']);
    Route::delete('friends/{friend}', [\App\Http\Controllers\FriendController::class, 'remove']);
    Route::post('friends/{user}/accept', [\App\Http\Controllers\FriendController::class, 'accept']);
    Route::post('friends/{user}/deny', [\App\Http\Controllers\FriendController::class, 'deny']);
});
