<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Checkin;
use \Auth;
use \DB;
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

    public function checkin($id, $latitude, $longitude)
    {
        $place = json_decode($this->placeController->getPlaceById($id));
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

    public function getLatestCheckin()
    {
        $checkin  = DB::table('checkins')->where('userId',Auth::id())->orderBy('created_at', 'DESC')->first();
        if (!$checkin)
        {
            return null;
        }
        return $checkin;
    }
}
