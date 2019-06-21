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
    Route::post('login', 'AuthController@login')->name('login');
    Route::prefix('users')->group(function(){
        Route::post('/', 'UserController@store')->name('register');
    });

    Route::prefix('s3')->group(function(){
        Route::post('upload', 'UploadController@upload')->name('s3.upload');
    });

    Route::prefix('resource')->group(function(){
       Route::get('{name}', 'ResourceController@getUrl')->name('resource.url');
    });
});