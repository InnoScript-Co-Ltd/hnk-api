<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AdminAuthController@login');
});

Route::middleware('jwt')->group(function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'AdminController@index');
        Route::post('/', 'AdminController@store');
        Route::get('/{id}', 'AdminController@show');
        Route::post('/{id}', 'AdminController@update');
        Route::delete('/{id}', 'AdminController@destroy');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('/{id}', 'UserController@show');
        Route::post('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });

    Route::group(['prefix' => 'singer'], function () {
        Route::get('/', 'SingerController@index');
        Route::post('/', 'SingerController@store');
        Route::get('/{id}', 'SingerController@show');
        Route::post('/{id}', 'SingerController@update');
        Route::delete('/{id}', 'SingerController@destroy');
    });

    Route::group(['prefix' => 'genres'], function () {
        Route::get('/', 'GenresController@index');
        Route::post('/', 'GenresController@store');
        Route::get('/{id}', 'GenresController@show');
        Route::post('/{id}', 'GenresController@update');
        Route::delete('/{id}', 'GenresController@destroy');
    });

    Route::group(['prefix' => 'song'], function () {
        Route::get('/', 'SongController@index');
        Route::post('/', 'SongController@store');
        Route::get('/{id}', 'SongController@show');
        Route::post('/{id}', 'SongController@update');
        Route::delete('/{id}', 'SongController@destroy');
    });

    Route::group(['prefix' => 'outlet'], function () {
        Route::get('/', 'OutletController@index');
        Route::post('/', 'OutletController@store');
        Route::get('/{id}', 'OutletController@show');
        Route::put('/{id}', 'OutletController@update');
        Route::delete('/{id}', 'OutletController@destroy');
    });

});
