<?php

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

Route::group(['prefix' => 'user'], function () {
    Route::post('/', 'UserController@store');
    Route::get('/{id}', 'UserController@show');
    Route::post('/{id}/vote/genre', 'UserController@voteGenre');
});

Route::group(['prefix' => 'singer'], function () {
    Route::get('/', 'SingerController@index');
    Route::get('/{id}', 'SingerController@show');
});

Route::group(['prefix' => 'promotion-slider'], function () {
    Route::get('/', 'PromotionSliderController@index');
    Route::get('/{id}', 'PromotionSliderController@show');
});

Route::group(['prefix' => 'genre'], function () {
    Route::get('/', 'GenresController@index');
    Route::get('/{id}', 'GenresController@show');
});

Route::group(['prefix' => 'song'], function () {
    Route::get('/', 'SongController@index');
    Route::get('/{id}', 'SongController@show');
});

Route::group(['prefix' => 'outlet'], function () {
    Route::get('/', 'OutletController@index');
    Route::get('/{id}', 'OutletController@show');
});

Route::group(['prefix' => 'lyric'], function () {
    Route::get('/', 'LyricController@index');
    Route::get('/{id}', 'LyricController@show');
});

Route::group(['prefix' => 'playlist'], function () {
    Route::get('/', 'PlaylistController@index');
    Route::post('/', 'PlaylistController@store');
    Route::get('/{id}', 'PlaylistController@show');
});

Route::group(['prefix' => 'video-upload'], function () {
    Route::get('/', 'VideoUploadController@index');
    Route::get('/{id}', 'VideoUploadController@show');
});

Route::group(['prefix' => 'singer-in-song'], function () {
    Route::get('/', 'SingerSongController@singerInSong');
    Route::get('/{id}', 'SingerSongController@show');
});

Route::group(['prefix' => 'event-slider'], function () {
    Route::get('/', 'EventController@index');
    Route::get('/{id}', 'EventController@show');
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
        Route::post('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });

    Route::group(['prefix' => 'singer'], function () {
        Route::post('/', 'SingerController@store');
        Route::post('/{id}', 'SingerController@update');
        Route::delete('/{id}', 'SingerController@destroy');
    });

    Route::group(['prefix' => 'promotion-slider'], function () {
        Route::post('/', 'PromotionSliderController@store');
        Route::post('/{id}', 'PromotionSliderController@update');
        Route::delete('/{id}', 'PromotionSliderController@destroy');
    });

    Route::group(['prefix' => 'event'], function () {
        Route::get('/', 'EventController@index');
        Route::post('/', 'EventController@store');
        Route::get('/{id}', 'EventController@show');
        Route::post('/{id}', 'EventController@update');
        Route::delete('/{id}', 'EventController@destroy');
    });

    Route::group(['prefix' => 'genre'], function () {
        Route::post('/', 'GenresController@store');
        Route::post('/{id}', 'GenresController@update');
        Route::delete('/{id}', 'GenresController@destroy');
    });

    Route::group(['prefix' => 'song'], function () {
        Route::post('/', 'SongController@store');
        Route::post('/{id}', 'SongController@update');
        Route::delete('/{id}', 'SongController@destroy');
    });

    Route::group(['prefix' => 'outlet'], function () {
        Route::post('/', 'OutletController@store');
        Route::post('/{id}', 'OutletController@update');
        Route::delete('/{id}', 'OutletController@destroy');
    });

    Route::group(['prefix' => 'genre-in-song'], function () {
        Route::get('/', 'GenreInSongController@index');
        Route::post('/', 'GenreInSongController@store');
        Route::get('/{id}', 'GenreInSongController@show');
        Route::put('/{id}', 'GenreInSongController@update');
    });

    Route::group(['prefix' => 'genre-in-singer'], function () {
        Route::get('/', 'GenreInSingerController@index');
        Route::post('/', 'GenreInSingerController@store');
        Route::get('/{id}', 'GenreInSingerController@show');
        Route::put('/{id}', 'GenreInSingerController@update');
    });

    Route::group(['prefix' => 'singer-song'], function () {
        Route::post('/', 'SingerSongController@store');
        Route::get('/', 'SingerSongController@index');
        Route::put('/{id}', 'SingerSongController@update');
    });

    Route::group(['prefix' => 'lyric'], function () {
        Route::get('/', 'LyricController@index');
        Route::post('/', 'LyricController@store');
        Route::put('/{id}', 'LyricController@update');
        Route::delete('/{id}', 'LyricController@destroy');
    });

    Route::group(['prefix' => 'music'], function () {
        Route::get('/', 'MusicController@index');
        Route::post('/', 'MusicController@store');
        Route::get('/{id}', 'MusicController@show');
        Route::post('/{id}', 'MusicController@update');
    });

    Route::group(['prefix' => 'playlist'], function () {
        Route::put('/{id}', 'PlaylistController@update');
        Route::delete('/{id}', 'PlaylistController@destroy');
    });

    Route::group(['prefix' => 'video-upload'], function () {
        Route::post('/', 'VideoUploadController@store');
        Route::put('/{id}', 'VideoUploadController@update');
        Route::delete('/{id}', 'VideoUploadController@destroy');
    });

});
