<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpereinceController;
use App\Http\Controllers\avaibletimeController;


Route::controller(avaibletimeController::class)->group(function () {

    Route::get('experts/{id}/avaible_times/{week}','show');

    Route::post('mytimes/add','store');
});
