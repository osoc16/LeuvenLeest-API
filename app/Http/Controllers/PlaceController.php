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
    public function addPlace($name, $latitude, $longitude)
    {
        return $this->create($name, $latitude, $longitude);
    }

    public function getPlaceById($id)
    {
        return json_encode(DB::table('places')->where('id',$id)->first());
    }

    public function getPlaces($lat, $lng)
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

    private function create($name, $lat, $long)
    {
        //Create a new geolocation for a place
        try
        {
            $geoLocation = new GeoLocation();
            $geoLocation->latitude = $lat;
            $geoLocation->longitude = $long;
            $geoLocation->save();
        } catch (Exception $ex)
        {
            return 'We are not able to create a new geolocation.';
        }

        //Create a new place
        try
        {
            $place = new Place();
            $place->foursquareId = null;
            $place->name = $name;
            $place->geoId = $geoLocation->id;
            $place->save();
            return json_encode($place);

        } catch (Exception $ex)
        {
            return 'We are not able to create a new place.';
        }
    }
}
