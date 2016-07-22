<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Checkin;
use \Auth;
use \DB;
use Validator;
use Illuminate\Http\Response;

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
        $place = DB::table('places')
            ->where('id',$input['id'])
            ->first();

        if (!$place)
        {
            return new Response('We weren\'t able to find the place', 404);
        }

        try
        {
            $geoLocation = $this->geolocationController->create($input['longitude'], $input['latitude']);
            $checkin = new Checkin();
            $checkin->placeId = $place->id;
            $checkin->geoId = $geoLocation->id;
            $checkin->userId = Auth::user()->id;
            $checkin->save();
        } catch(Exception $ex) {
            return new Response('We weren\'t able to create a new place.', 500);
        }
        return new Response(json_encode($checkin), 201);
    }

    public function getLatestCheckin()
    {
        $id = Auth::user()->id;
        $checkin  = DB::table('checkins')->where('userId', $id)->orderBy('created_at', 'DESC')->first();
        if ($checkin)
        {
            return new Response(json_encode($checkin), 200);
        }
        return new Response('You haven\'t checked in yet.', 404);
    }

    public function getRecentCheckins()
    {
        $id = Auth::user()->id;
        $places = DB::table('checkins')
            ->join('places','checkins.placeId','=','places.id')
            ->join('photos', 'places.photoId', '=', 'photos.id')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->where('checkins.userId', $id)
            ->select(
                'places.id',
                'places.name',
                'places.address',
                'places.description',
                'places.email',
                'places.site',
                'geolocations.*',
                'categories.name as category',
                'categories.icon',
                'photos.name as photo'
                )
            ->groupBy('places.id')
            ->orderBy('checkins.updated_at', 'DESC')
            ->take(6)
            ->get();
        if ($places)
        {
            return new Response($places, 200);
        }
        return new Response('You haven\'t checked in yet', 400);
    }
}
