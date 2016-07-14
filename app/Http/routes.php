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

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//oAuth routes
Route::get('auth/login/{client}', 'Auth\AuthController@login');
Route::get('auth/loginCallback/{client}', 'Auth\AuthController@loginCallback');

//Place
Route::put('/places/add','PlaceController@store');
Route::get('/places/getPlacesByCategory/{categoryId}/{lat}/{lng}','PlaceController@getPlacesByCategory');
Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');
Route::get('/places/{id}','PlaceController@getPlaceById');

//Checkin
Route::put('/checkin','CheckinController@store');
Route::get('/checkin/latest','CheckinController@getLatestCheckin');
Route::get('/checkin/recent','CheckinController@getRecentCheckins');
