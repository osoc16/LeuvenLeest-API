<?php

use Illuminate\Http\Request;
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
Route::put('/auth/register', 'Auth\AuthController@postRegister');

// oAuth routes
Route::get('auth/login/{client}', 'Auth\AuthController@login');
Route::get('auth/loginCallback/{client}', 'Auth\AuthController@loginCallback');

Route::group(['middleware' => ['jwt.auth']], function () {
    //Place
    Route::get('/places/trending', 'PlaceController@getTrendingPlaces');
    Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');
    Route::get('/places/{id}','PlaceController@getPlaceById')->where('id', '[0-9]+');
    Route::get('/places/getPlacesByCategory/{categoryId}/{lat}/{lng}','PlaceController@getPlacesByCategory')->where('categoryId', '[0-9]+');
    Route::put('/places/add','PlaceController@store');
    Route::post('/places/{id}/addToFavourites','PlaceController@addToFavourites')->where('id', '[0-9]+');
    Route::post('/places/{id}/removeFromFavourites','PlaceController@removeFromFavourites')->where('id', '[0-9]+');

    //Checkin
    Route::put('/checkin','CheckinController@store');
    Route::get('/checkin/latest','CheckinController@getLatestCheckin');
    Route::get('/checkin/recent','CheckinController@getRecentCheckins');

    // Users
    Route::get('/user/get/{id}','UserController@getUserById');
});
