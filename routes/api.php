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
   Route::apiResource('todolists', \App\Http\Controllers\TodolistController::class);
});
