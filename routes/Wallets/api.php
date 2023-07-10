<?php

use Illuminate\Support\Facades\Route;


Route::post('wallet/create','store');

Route::get('mywallet', 'show');

Route::post('mywallet/budget/add', 'addvalue');
