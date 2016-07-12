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

// Search routes
Route::get('/searching', 'SearchController@searching');
Route::get('/search', 'SearchController@search');

// Check-in routes
Route::get('/db/checkin', 'CheckinController@overview');