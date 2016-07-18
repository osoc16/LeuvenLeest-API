<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Place;
use App\Providers\FoursquareProvider;
use \DB;
use Validator;
use App\Geolocation;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Response;

class PlaceController extends Controller
{
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
            ->where('id',$id)
            ->first();
        if ($place)
        {
            $place = json_encode($place);
            return new Response($place, 200);
        }
        return new Response('Place not found', 404);
    }

    public function getPlaces($lat, $lng)
    {
        $places = DB::table('places')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->get();

        return new Response($this->sortByDistance($places, $lat, $lng), 200);
    }

    public function getPlacesByCategory($categoryId, $lat, $lng)
    {
        $places = DB::table('categories')
            ->join('places', 'places.categoryId', '=', 'categories.id')
            ->join('geolocations', 'places.geoId', '=', 'geolocations.id')
            ->where('places.categoryId', $categoryId)->get();

        return json_encode($this->sortByDistance($places, $lat, $lng));
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
            return json_encode($places);
    }

    public function addToFavourites($id){
        try{
            $user = Auth::user();
            $place = App\Place::find($id);
            $place->isFavouriteFrom()->attach($user);
            $place->save();
            return (new Response('Succesfully added the place to your favourites.',200));
        } catch(Exception $ex){
            Log::error($ex);
            return 'We were not able to add this place to your favourites.';
        }
    }

    public function removeFromFavourites($id){
        try {
            $user = Auth::user();
            $place = App\Place::find($id);
            $place->isFavouriteFrom()->detach($user);
            $place->save();
            return (new Response('Successfully removed the place from your favourites.',200));
        } catch (Exception $ex){
            Log::error($ex);
            return 'We were not able to remove this place from you favourites.';
        }
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
            return 'We are not able to create a new geolocation.';
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
            return $place;

        } catch (Exception $ex)
        {
            return 'We are not able to create a new place.';
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
