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
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');


Route::get('/', function () {
	return view('welcome');
});

// Authentication routes...
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
Route::post('auth/register', 'Auth\AuthController@postRegister');

// oAuth routes
Route::get('auth/login/{client}', 'Auth\AuthController@login');
Route::get('auth/loginCallback/{client}', 'Auth\AuthController@loginCallback');


Route::group(['middleware' => ['jwt.auth']], function () {
    //Place
    Route::put('/places/add','PlaceController@store');
    Route::get('/places/getPlacesByCategory/{categoryId}/{lat}/{lng}','PlaceController@getPlacesByCategory');
    Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');
    Route::get('/places/{id}','PlaceController@getPlaceById');

    //Checkin
    Route::put('/checkin','CheckinController@store');
    Route::get('/checkin/latest/{id}','CheckinController@getLatestCheckin');
    Route::get('/checkin/recent/{id}','CheckinController@getRecentCheckins');

    // Users
    Route::get('/user/get/{id}','UserController@getUserById');
});
