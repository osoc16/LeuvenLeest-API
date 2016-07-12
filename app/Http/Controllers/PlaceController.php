<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Place;
use App\Providers\FoursquareProvider;
use Debugbar;
use \DB;
use App\Geolocation;

class PlaceController extends Controller
{

    private function checkIfPlaceExists($foursquareId = '50655812e4b07b9787f62cdf')
    {
        return DB::table('places')->where('foursquareId', $foursquareId)->get() ? true : false;
    }

    public function getPlaceById($foursquareId)
    {
        if(!$this->checkIfPlaceExists($foursquareId))
        {
            $foursquareProvider = new FoursquareProvider();
            $venue = $foursquareProvider->getPlaceById($foursquareId);
            return $this->create($venue->response->venue);
        }
        return DB::table('places')->where('foursquareId',$foursquareId)->first();
    }

    private function create($venue)
    {
        //Create a new geolocation for a place
        try
        {
            $geoLocation = new GeoLocation();
            $geoLocation->latitude = $venue->location->lat;
            $geoLocation->longitude = $venue->location->lng;
            $geoLocation->save();
        } catch (Exception $ex)
        {
            return 'We are not able to create a new geolocation.';
        }

        //Create a new place
        try
        {
            $place = new Place();
            $place->foursquareId = $venue->id;
            $place->name = $venue->name;
            $place->geoId = $geoLocation->id;
            return $place->save();
        } catch (Exception $ex)
        {
            return 'We are not able to create a new place.';
        }
    }
}
