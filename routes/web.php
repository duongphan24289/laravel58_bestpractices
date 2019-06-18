<?php

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

if(! app()->environment('local')){
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/search', 'UserController@testSearch');
