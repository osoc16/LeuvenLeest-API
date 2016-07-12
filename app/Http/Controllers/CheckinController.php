<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Checkin;
use App\Geolocation;
use Debugbar;

class CheckinController extends Controller
{
    public function checkin($foursquareId, $longitude, $latitude)
    {
        if (!$foursquareId || !$longitude || !$latitude)
        {
            return 'Forgotten param';
        }
        $placeController = new PlaceController();
        $place = $placeController->getPlaceById($foursquareId);
        return $this->create($place, $longitude, $latitude);
    }

    private function create($place, $longitude, $latitude)
    {
        try
        {
            $geoLocation = new Geolocation();
            $geoLocation->longitude = $longitude;
            $geoLocation->latitude = $latitude;
            $geoLocation->save();
            $checkin = new Checkin();
            $checkin->placeId = $place->id;
            $checkin->geoId = $geoLocation->id;
            $checkin->userId = 1;
            $checkin->save();
        } catch(Exception $ex) {
            throw new Exception('Error');
        }
        return $checkin;
    }
}
