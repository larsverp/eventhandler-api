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

#Users endpoint route
Route::post('users/login', 'UserController@check');
Route::post('users/register', 'UserController@create');

#Events endpoint route
Route::get('events', 'EventsController@index');
Route::get('events/{id}', 'EventsController@show')->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$');
Route::post('events', 'EventsController@create')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::put('events/{id}', 'EventsController@update')->middleware(['auth:api', 'scope:rockstar'])
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::delete('events/{id}', 'EventsController@remove')->middleware(['auth:api', 'scope:rockstar'])
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
