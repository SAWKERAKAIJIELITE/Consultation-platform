<?php

use Illuminate\Support\Facades\Route;


Route::get('people/experts', 'index');

Route::get('people/experts/{id}', 'show');

Route::get('experts/type/specialtiy/{speciality}', 'indexBySpeciality');

Route::get('experts/{name}', 'search');

Route::group(['middleware'=>'auth:sanctum'],function () {

    Route::post('create/expert', 'store');
});
