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
Route::get('/places','PlaceController@addPlace');

Route::get('/', function () {
    $response = json_decode(file_get_contents(
    		'https://api.foursquare.com/v2/venues/search'
    		.'?client_id=QLT3TADFL45N2RUDTNPZO3DELG4G4ENPGJCVDIUL3CVFBWQJ'
    		.'&client_secret=TXHQIDDTDZLDVLXLS3MQHNQE1T4SGN1VWWDNX3FWAEUPVHS4'
    		.'&v=20150806&m=foursquare'
    		.'&near=leuven'))->response;
    return json_encode($response->venues);
});
