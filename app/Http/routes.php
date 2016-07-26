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
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Methods: POST, GET, PUT');
header('Access-Control-Expose-Headers', 'Authorization');


Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::post('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
Route::put('/auth/register', 'Auth\AuthController@postRegister');

// oAuth routes
Route::get('auth/login/{client}', 'Auth\AuthController@login');
Route::post('auth/loginCallback/{client}', 'Auth\AuthController@loginCallback');

//Places endpoints needed when not logged in yet
Route::get('/places/{lat}/{lng}','PlaceController@getPlaces');

Route::group(['middleware' => ['jwt.auth','jwt.refresh']], function () {
    //Place
    Route::get('/places/getPlacesByCategory/{categoryId}/{lat}/{lng}','PlaceController@getPlacesByCategory')->where('categoryId', '[0-9]+');
    Route::get('/places/{id}/photos','PhotoController@getPictures')->where('id', '[0-9]+');
    Route::post('/places/{id}/addToFavourites','FavouriteController@addToFavourites')->where('id', '[0-9]+');
    Route::post('/places/{id}/removeFromFavourites','FavouriteController@removeFromFavourites')->where('id', '[0-9]+');
    Route::post('/places/{id}/uploadPhoto','PhotoController@uploadPhoto')->where('id','[0-9]+');
    Route::post('/places/{id}/addOpeningHours','OpeningHoursController@addOpeningHours')->where('id','[0-9]+');
    Route::post('/places/{id}/updateOpeningHours','OpeningHoursController@updateOpeningHours')->where('id','[0-9]+');
    Route::get('/places/trending', 'PlaceController@getTrendingPlaces');
    Route::get('/places/favourite', 'FavouriteController@getFavouritePlaces');
    Route::put('/places/add','PlaceController@store');
    Route::get('/places/{id}','PlaceController@getPlaceById')->where('id', '[0-9]+');

    //Checkin
    Route::get('/checkin/latest','CheckinController@getLatestCheckin');
    Route::get('/checkin/recent','CheckinController@getRecentCheckins');
    Route::put('/checkin','CheckinController@store');

    // Users
    Route::get('/user/{id}','UserController@getUserById')->where('id', '[0-9]+');
    Route::get('/user/current', 'UserController@getAccountDetails');

    // Questions
    Route::get('/questions/get','QuestionsController@getRandomQuestion');
    Route::get('/questions','QuestionsController@getQuestions');
    Route::get('/evaluations/rating/{placeId}','QuestionsController@getRating');
    Route::get('/evaluations/{id}','QuestionsController@getEvaluations');
    Route::get('/evaluate/{placeId}/{questionId}/{vote}','QuestionsController@evaluate');

});
