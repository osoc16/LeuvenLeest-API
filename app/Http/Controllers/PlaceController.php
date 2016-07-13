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

    public function getpla($foursquardId)
    {
        if(!$this->checkIfPlaceExists($foursquareId))
        {
            $foursquareProvider = new FoursquareProvider();
            $venue = $foursquareProvider->getPlaceById($foursquareId);
            Debugbar::info($venue);
            return $this->create($venue->response->venue);
        }
        return DB::table('places')->where('foursquareId', $foursquareId)->get();
    }

    public function getPlaces($lng, $lat)
    {
        $places = DB::table('places')
                    ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
                    ->get();

        foreach ($places as $place)
        {
            // Calculate distance 
            $lon1 = $lng;
            $lat1 = $lat;

            $lon2 = $place->longitude;
            $lat2 = $place->latitude;

            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $meters = ($dist * 60 * 1.1515) * 1.609344;

            $place->distance = $meters;
        }

        usort($places, function($a, $z) { return $a->distance > $z->distance; });        
        return $places;
    }

    private function create($venue)
    {
        Debugbar::info($venue->location);
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
