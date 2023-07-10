<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\trait_response;


Route::post('consultations/create','store');

Route::get('consultations/type', function(){
    return trait_response::api_response([
        'medical',
        'family',
        'psychology',
        'other',
        'finance'
    ],status:200);
});

Route::get('getkind/{name}', function($name){
    $kind=[
        'medical',
        'family',
        'psychology',
        'other',
        'finance'
    ];

    if(in_array($name,$kind))
        return trait_response::api_response($name,status:200);
    else
        return trait_response::api_response(null,'not exist',status:200);
});

Route::post('myconsultations/{id}/rate/{value}', 'rate');

Route::get('myconsultations/presented','showForExpert');

Route::get('myconsultations', 'showForUser');
