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


Route::get('/', function () { return view('welcome'); });

//Place
Route::put('/places/add','PlaceController@store');
Route::get('/places/getPlacesByCategory/{categoryId}/{lat}/{lng}','PlaceController@getPlacesByCategory');
Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');
Route::get('/places/{id}','PlaceController@getPlaceById');

//Checkin
Route::put('/checkin','CheckinController@store');
Route::get('/getLatestCheckin','CheckinController@getLatestCheckin');
