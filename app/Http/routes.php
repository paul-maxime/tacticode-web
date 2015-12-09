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

Route::get('/', 'AppController@index');

Route::post('/login', 'AuthController@login');

Route::get('/logout', 'AuthController@logout');

Route::get('/register', 'UsersController@create');
Route::post('/register', 'UsersController@store');
Route::get('/dashboard', 'UsersController@index');

Route::get('/edit', 'UsersController@edit');
Route::post('/edit', 'UsersController@update');
Route::post('/changepassword', 'UsersController@updatePassword');

Route::get('/checkloginexists/{login}', 'UsersController@loginexists');
Route::get('/checkemailexists/{email}', 'UsersController@emailexists');

Route::get('/user', function() {
	return view('user.index');
});
Route::post('/user/', function() {
	return view('user.index');
});

Route::get('/characters', function() {
	return view('characters.index');
});

Route::get('/characters/{id}', function() {
	return view('characters.view');
});

Route::post('/characters/{id}', function() {
	return view('characters.view');
});