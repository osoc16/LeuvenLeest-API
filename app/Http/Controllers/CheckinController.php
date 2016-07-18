<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Checkin;
use \Auth;
use \DB;
use Validator;

class CheckinController extends Controller
{
    private $placeController;
    private $geolocationController;

    public function __construct()
    {
        $this->placeController = new PlaceController();
        $this->geolocationController = new GeolocationController();
    }

    public function store(Request $request)
    {
        $expected = [
            'id',
            'longitude',
            'latitude'
        ];

        $input = $request->only($expected);

        $validator = Validator::make($input, $this->getValidationRules());

        if ($validator->fails())
        {
            return $validator->errors();
        }
        return $this->create($input);

    }

    private function getValidationRules()
    {
        return [
            'id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ];
    }

    private function create($input)
    {
        $place = json_decode($this->placeController->getPlaceById($input['id']));

        try
        {
            $geoLocation = $this->geolocationController->create($input['longitude'], $input['latitude']);
            $checkin = new Checkin();
            $checkin->placeId = $place->id;
            $checkin->geoId = $geoLocation->id;
            $checkin->userId = Auth::user()->id;
            $checkin->save();
        } catch(Exception $ex) {
            throw new Exception('Error');
        }
        return $checkin;
    }

    public function getLatestCheckin($id)
    {
        $checkin  = DB::table('checkins')->where('userId', $id)->orderBy('created_at', 'DESC')->first();
        return json_encode($checkin);
    }

    public function getRecentCheckins($id)
    {
        $places = DB::table('checkins')
            ->join('places','checkins.placeId','=','places.id')
                        ->where('checkins.userId', $id)

            ->select('places.*')
            ->orderBy('checkins.updated_at', 'DESC')
            ->take(6)
            ->get();
        return $places;
    }
}
