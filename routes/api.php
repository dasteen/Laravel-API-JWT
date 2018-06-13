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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

    Route::post('login', 'LoginController@authenticate')->name('login');

//    Route::get('users', 'LoginController@index')->name('index')->middleware('jwt.auth');

    Route::Resource('posts', 'PostController')->middleware('jwt.auth')
        ->except(['create','edit','update']);

});