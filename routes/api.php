<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/login', 'UserController@check');
Route::post('users/register', 'UserController@create');

#TODO test if  the middleware routes checks are working.
Route::get('events', 'EventsController@index');
Route::get('events/{id}', 'EventsController@show');
Route::post('events', 'EventsController@create')->middleware(['auth:api', 'scope:rockstar']);
Route::put('events/{id}', 'EventsController@update')->middleware(['auth:api', 'scope:rockstar']);
Route::delete('events/{id}', 'EventsController@remove')->middleware(['auth:api', 'scope:rockstar']);
