<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Checkin;
use \Auth;
use \DB;
use Validator;
use Illuminate\Http\Response;
use \JWTAuth;
use App\Http\Controllers\Auth\AuthController;

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
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'We weren\'t able to find the place', 404);
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
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'We weren\'t able to create a new place.', 500);
        }
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),json_encode($checkin), 201);
    }

    public function getLatestCheckin()
    {
        $id = Auth::user()->id;
        $checkin  = DB::table('checkins')->where('userId', $id)->orderBy('created_at', 'DESC')->first();
        if ($checkin)
        {
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),json_encode($checkin), 200);
        }
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'You haven\'t checked in yet.', 404);
    }

    public function getRecentCheckins()
    {
        $id = JWTAuth::toUser()->id;

        $array = DB::select(DB::raw("(select placeId,max(id) as maximum from checkins where userId='$id' group by placeId order by 1 DESC)"));
        $newArray = [];

        foreach($array as $item){
            $newArray[] = (int)$item->maximum;
        }


        $checkinIds = DB::table('checkins')
            ->whereIn('id', $newArray)
            ->select('id')
            ->take(6)
            ->get();

        $newArray = [];
        foreach($checkinIds as $item){
            $newArray[] = (int)$item->id;
        }

        //var_dump($newArray);

        $places = DB::table('checkins')
            ->join('places','checkins.placeId','=','places.id')
            ->leftjoin('photos', 'places.id', '=', 'photos.placeId')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->join('categories', 'categories.id', '=', 'places.categoryId')
            ->whereIn('checkins.id',$newArray)
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

            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$places, 200);
    }
}
