<?php

use App\Http\Controllers\MailsController;
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
Route::post('users/validation', 'UserController@validation');
Route::post('users/register/rockstar', 'UserController@rockstar')->middleware(['auth:api', 'scope:rockstar']);

#Admin user endpoint
Route::get('users', 'UserController@index')->middleware(['auth:api', 'scope:rockstar']);
Route::put('users/{id}', 'UserController@update')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::delete('users/{id}', 'UserController@remove')
    ->middleware(['auth:api', 'scope:rockstar']);

#Events endpoint route
Route::get('events', 'EventsController@index');
Route::get('events/{id}', 'EventsController@show')->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$');
Route::post('events', 'EventsController@create')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::put('events/{id}', 'EventsController@update')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::delete('events/{id}', 'EventsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);

#Mails endpoint route
Route::get('mails', 'MailsController@index')->middleware(['auth:api', 'scope:rockstar']);
Route::get('mails/{id}', 'MailsController@show')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::post('mails', 'MailsController@create')->middleware(['auth:api', 'scope:rockstar']);
Route::put('mails/{id}', 'MailsController@update')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::delete('mails/{id}', 'MailsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:rockstar']);
Route::post('mails/verify', 'MailsController@verify');
