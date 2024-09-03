<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\ApplicationTypeController;
use App\Http\Controllers\Api\AuthenticatedSessionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function (){
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth:api')->group(function (){
    Route::prefix('auth')->group(function (){
        Route::post('refresh', [AuthenticatedSessionController::class,'update']);
    });

    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    //Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::get('application-type', ApplicationTypeController::class);
    Route::get('locations', LocationController::class);

    Route::get('application',[ApplicationController::class,'index']);
    Route::post('application/create',[ApplicationController::class,'store']);
});

