<?php

use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::namespace('API')->group(function(){
   Route::prefix('users')->group(function(){
      Route::post('/', 'UserController@store')->name('register');
   });
});

//Route::group(['namespace' => 'API'], function(){
//    /*
//     * Login
//     */
//    Route::post('login', 'AuthController@login')->name('login');
//
//    /*
//     * Register user
//     */
//    Route::
//    Route::prefix('users')->post('/', 'UserController@store')->name('register');
//});
