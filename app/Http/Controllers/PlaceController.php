<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Place;
use App\OpeningHours;
use App\Http\Controllers\Auth\AuthController;
use App\Providers\FoursquareProvider;
use \DB;
use Validator;
use App\Geolocation;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\OpeningHoursController;
use \JWTAuth;


class PlaceController extends Controller{

    public function store(Request $request)
    {
        $expected = [
            'name',
            'address',
            'description',
            'email',
            'categoryId',
            'site',
            'latitude',
            'longitude'
        ];

        $input = $request->only($expected);

        $validator = Validator::make($input, $this->getRulesForValidation());

        if ($validator->fails())
        {
            return $validator->errors();
        }
        return $this->create($input);
    }

    public function getPlaceById($id)
    {
        $place = DB::table('places')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->join('categories', 'places.categoryId', '=', 'categories.id')
            ->leftjoin('photos', 'places.id', '=', 'photos.placeId')
            ->where('places.id', $id)
            ->select(
                'places.id',
                'places.name',
                'places.address',
                'places.description',
                'places.email',
                'places.site',
                'geolocations.*',
                'categories.name as category',
                'photos.name as photo'
                )
            ->first();
        if ($place)
        {
            $hours = OpeningHours::where('placeId',$id)->get();
            $place->openingHours = $hours ? (new OpeningHoursController)->getOpeningHours($id) : '';
            $place = json_encode($place);
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$place,200);
        }
        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'Place not found', 400);
    }

    public function getPlaces($lat, $lng)
    {
        $places = DB::table('places')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->join('categories', 'places.categoryId', '=', 'categories.id')
            ->leftjoin('photos', 'places.id', '=', 'photos.placeId')
            ->select(
                'places.id',
                'places.name',
                'places.address',
                'places.description',
                'places.email',
                'places.site',
                'geolocations.*',
                'categories.name as category',
                'photos.name as photo'
                )
            ->get();

        $places = $this->sortByDistance($places, $lat, $lng);        

        return new Response(array_slice($places, 0, 10), 200);
    }

    public function getPlacesByCategory($categoryId, $lat, $lng)
    {
        $places = DB::table('categories')
            ->join('places', 'places.categoryId', '=', 'categories.id')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->leftjoin('photos', 'places.id', '=', 'photos.placeId')
            ->where('places.categoryId', $categoryId)
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
            ->get();

        return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$this->sortByDistance($places, $lat, $lng),200);
    }

    public function getTrendingPlaces()
    {
        $places = DB::table('checkins')
            ->join('places', 'places.id', '=', 'checkins.placeId')
            ->select('places.*', DB::raw('count(*) as checkin_count, checkins.placeId'))
            ->where('checkins.created_at', '>', Carbon::now()->subWeek())
            ->groupBy('places.id')
            ->orderBy('checkin_count', 'DESC')
            ->take(5)
            ->get();
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),$place,200);
    }

    private function sortByDistance($places, $lat, $lng)
    {
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

    private function create($input)
    {
        //Create a new geolocation for a place
        try
        {
            $geoLocation = new GeoLocation();
            $geoLocation->latitude = $input['latitude'];
            $geoLocation->longitude = $input['longitude'];
            $geoLocation->save();
        } catch (Exception $ex)
        {
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'We are not able to create a new geolocation.', 500);
        }

        //Create a new place
        try
        {
            $place = new Place();
            $place->foursquareId = null;
            $place->name = $input['name'];
            $place->address = $input['address'];
            $place->description = $input['description'];
            $place->email = $input['email'];
            $place->categoryId = $input['categoryId'];
            $place->site = $input['site'];
            $place->geoId = $geoLocation['id'];
            $place->save();
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),json_encode($place),201);

        } catch (Exception $ex)
        {
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'We are not able to create a new place.', 500);
        }

        //Add evaluations
        try
        {
            for ($i = 0; $i < 4; $i++)
            {
                $evaluation = new Evaluation();
                $evaluation->placeId = $input['placeId'];
                $evaluation->save();
            }

            return new Response(json_encode($evaluation), 201);

        } catch (Exception $ex)
        {
            return (new AuthController)->checkToken(JWTAuth::getToken(),JWTAuth::getPayload(),'We are not able to create a new evaluation.', 500);
        }
    }

    private function getRulesForValidation()
    {
        return [
            'name' => 'required',
            'address' => '',
            'description' => '',
            'email' => 'required',
            'categoryId' => 'required',
            'site' => '',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
    }
}
