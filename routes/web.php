<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return 'Only API calls are allowed.';
// });

Route::any('/', function () {
    $message = ['message' => 'This URL is used as a REST API. This means only API calls are allowed!'];
    return response(json_encode($message), 405);
})->name('default');

Route::any('/{any}', function () {
   return redirect()->route('default');
});
