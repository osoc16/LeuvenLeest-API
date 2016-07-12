<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Geolocation;

class GeolocationController extends Controller
{
    public function create($longitude, $latitude)
    {
        $geoLocation = new Geolocation();
        $geoLocation->longitude = $longitude;
        $geoLocation->latitude = $latitude;
        $geoLocation->save();
        return $geoLocation;
    }
}
