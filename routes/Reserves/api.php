<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\PersonController;


Route::controller(ReserveController::class)->group(function () {

    Route::post('reserve/create', 'store');

    Route::get('myreserves/expert',  'showForExpert');
});

Route::get('myreserves/user',[PersonController::class,'showReservesForUser']);
