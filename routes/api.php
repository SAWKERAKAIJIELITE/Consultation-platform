<?php

use Illuminate\Http\Request;
use App\Http\Controllers\auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[auth::class,'register']);

Route::post('/login',[auth::class,'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('myaccount/logout',[auth::class, 'logout']);

    Route::post('myaccount/delete',[auth::class, 'delete_account']);

});
