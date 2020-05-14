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
    return $request->user()->role;
})->name('auth');

#Users endpoints
Route::post('users/login', 'UserController@check');
Route::post('users/register', 'UserController@create');
Route::post('users/validation', 'UserController@validation');
Route::post('users/register/rockstar', 'UserController@rockstar')->middleware(['auth:api', 'scope:admin']);
Route::post('users/register/admin', 'UserController@admin')->middleware(['auth:api', 'scope:admin']);

#Admin endpoints
Route::get('users', 'UserController@index')->middleware(['auth:api', 'scope:admin']);
Route::put('users/{id}', 'UserController@update')
    ->middleware(['auth:api', 'scope:admin']);
Route::delete('users/{id}', 'UserController@remove')
    ->middleware(['auth:api', 'scope:admin']);

#Events endpoints
Route::get('events', 'EventsController@index')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::get('events/preview', 'EventsController@preview');
Route::get('events/{id}', 'EventsController@show')->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$');
Route::post('events', 'EventsController@create')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::put('events/{id}', 'EventsController@update')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::delete('events/{id}', 'EventsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);

#Mails endpoints
Route::get('mails', 'MailsController@index')->middleware(['auth:api', 'scope:admin']);
Route::get('mails/{id}', 'MailsController@show')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::post('mails', 'MailsController@create')->middleware(['auth:api', 'scope:admin']);
Route::put('mails/{id}', 'MailsController@update')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::delete('mails/{id}', 'MailsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::post('mails/verify', 'MailsController@verify');

#Favorite endpoints
Route::get('favorites', 'FavoritesController@show')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::post('favorites', 'FavoritesController@create')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::delete('favorites/{id}', 'FavoritesController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);

#Ticket endpoints
Route::get('tickets', 'TicketsController@show')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::post('tickets', 'TicketsController@create')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::delete('tickets/{id}', 'TicketsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::post('tickets/scan', 'TicketsController@scan')->middleware(['auth:api', 'scope:admin']);

#Hosts endpoints
Route::get('hosts', 'HostsController@index');
Route::get('hosts/{id}', 'HostsController@show')->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$');
Route::post('hosts', 'HostsController@create')->middleware(['auth:api', 'scope:admin']);
Route::put('hosts/{id}', 'HostsController@update')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::delete('hosts/{id}', 'HostsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);

#Review endpoints
Route::get('reviews', 'ReviewsController@index')->middleware(['auth:api', 'scope:admin']);
Route::get('reviews/{id}', 'ReviewsController@show')->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$');
Route::get('reviews/check', 'ReviewsController@check')->middleware(['auth:api', 'scope:admin']);
Route::post('reviews', 'ReviewsController@create')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::post('reviews/approve/{id}', 'ReviewsController@approve')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::delete('reviews/{id}', 'ReviewsController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);

#category endpoints
Route::get('categories', 'CategoriesController@index')->middleware(['auth:api', 'scope:admin']);
Route::get('categories/event/{id}', 'CategoriesController@event')->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$');
Route::get('categories/{id}', 'CategoriesController@show')->middleware(['auth:api', 'scope:admin,rockstar,partner,guest']);
Route::post('categories', 'CategoriesController@create')->middleware(['auth:api', 'scope:admin']);
Route::put('categories/{id}', 'CategoriesController@update')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);
Route::delete('categories/{id}', 'CategoriesController@remove')
    ->where('id', '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$')
    ->middleware(['auth:api', 'scope:admin']);