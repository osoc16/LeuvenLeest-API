<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Checkin;
use Debugbar;

class CheckinController extends Controller
{
    private $placeController;
    private $geolocationController;

    public function __construct()
    {
        $this->placeController = new PlaceController();
        $this->geolocationController = new GeolocationController();
    }

    public function checkin($foursquareId, $longitude, $latitude)
    {
        if (!$foursquareId || !$longitude || !$latitude)
        {
            return 'Forgotten param';
        }
        $place = $this->placeController->getPlaceById($foursquareId);
        return $this->create($place, $longitude, $latitude);
    }

    private function create($place, $longitude, $latitude)
    {
        try
        {
            $geoLocation = $this->geolocationController->create($longitude, $latitude);
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
