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
Route::put('/places/add/{name}/{latitude}/{longitude}','PlaceController@addPlace');
Route::get('places/{id}','PlaceController@getPlaceById');
Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');

//Checkin
Route::post('/checkin/{foursquareId}/{latitude}/{longitude}','CheckinController@checkin');
Route::get('/getLatestCheckin','CheckinController@getLatestCheckin');
