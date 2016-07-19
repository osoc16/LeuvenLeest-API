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

// Route::group(['middleware' => ['cors']], function () {
    Route::get('/', function () {
    	return view('welcome');
    });

    // Authentication routes...
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@logout');

    // Registration routes...
    Route::put('auth/register', 'Auth\AuthController@postRegister');

    // oAuth routes
    Route::get('auth/login/{client}', 'Auth\AuthController@login');
    Route::get('auth/loginCallback/{client}', 'Auth\AuthController@loginCallback');


    // Route::group(['middleware' => ['jwt.auth']], function () {
        //Place
        Route::post('/places/{id}/uploadPhoto','PhotoController@uploadPhoto')->where('id','[0-9]+');
        Route::put('/places/add','PlaceController@store');
        Route::get('/places/getPlacesByCategory/{categoryId}/{lat}/{lng}','PlaceController@getPlacesByCategory');
        Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');
        Route::post('/places/{id}/addToFavourites','PlaceController@addToFavourites');
        Route::post('/places/{id}/removeFromFavourites','PlaceController@removeFromFavourites');
        Route::get('/places/{id}','PlaceController@getPlaceById');

        //Checkin
        Route::put('/checkin','CheckinController@store');
        Route::get('/checkin/latest','CheckinController@getLatestCheckin');
        Route::get('/checkin/recent','CheckinController@getRecentCheckins');

        // Users
        Route::get('/user/get/{id}','UserController@getUserById');
    // });
// });
