<?php

use Illuminate\Support\Facades\Route;


Route::get('people','index');

Route::put('myfavourites/add','addFavourites');

Route::get('myfavourites','showFavourites');

Route::get('myrate','rated');
