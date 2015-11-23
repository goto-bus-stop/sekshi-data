<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/achievements', 'AchievementController@index');
Route::get('/achievements/{id}', 'AchievementController@show');

Route::get('/emotes', 'EmoteController@index');

Route::get('/history', 'HistoryController@index');
Route::get('/most-played', 'HistoryController@mostPlayed');

Route::get('/media', 'MediaController@index');
Route::get('/media/{cid}', 'MediaController@show');

Route::get('/users', 'UserController@index');
Route::get('/user/{slug}', 'UserController@show');
