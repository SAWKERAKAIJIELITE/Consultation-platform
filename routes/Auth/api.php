<?php

use App\Http\Controllers\loginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('login',[loginController::class,'authenticate']);

Route::get('/user/tokens', [loginController::class,'userTokens'])->middleware(['auth:sanctum','abilities:server:update']);

Route::post('createTo',[loginController::class,'createTo'])->middleware('auth:sanctum');

Route::get('/user/token/abilities', [loginController::class,'getUserAbilities'])->middleware('auth:sanctum');
