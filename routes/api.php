<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[\App\Http\Controllers\UserAuthController::class,'register'])->middleware('api');
Route::post('login',[\App\Http\Controllers\UserAuthController::class,'login'])->middleware('api');
Route::post('logout',[\App\Http\Controllers\UserAuthController::class,'logout'])
    ->middleware('auth:sanctum');
