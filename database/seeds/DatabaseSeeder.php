<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(GeolocationSeeder::class);
        $this->call(PlaceSeeder::class);
    }
}

class GeolocationSeeder extends Seeder
{

    const ENDPOINT_URL = 'https://api.foursquare.com/v2/venues/search';
    const LOCATION = 'Leuven';
    const CATEGORY_IDS = '4bf58dd8d48988d163941735,4bf58dd8d48988d1e0931735,4bf58dd8d48988d1a7941735,4bf58dd8d48988d12f941735';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = json_decode(file_get_contents(
            $this::ENDPOINT_URL
            .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
            .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
            .'&ll=50.8798,4.7005'
            .'&v=20150806&m=foursquare'
            .'&radius=5000'
            .'&intent=checkin'
            .'&categoryId='.$this::CATEGORY_IDS
            .'&near='.$this::LOCATION))->response;

        $venues = $response->venues;

        foreach($venues as $venue){
            $exists = DB::table('geolocations')->where('longitude',$venue->location->lng)
                ->where('latitude',$venue->location->lat)->get();
            if(!$exists){
                DB::table('geolocations')->insert([['latitude' => $venue->location->lat,
                                                    'longitude' => $venue->location->lng]]);
            }
        }
    }
}

class PlaceSeeder extends Seeder
{

    const ENDPOINT_URL = 'https://api.foursquare.com/v2/venues/search';
    const LOCATION = 'Leuven';
    const CATEGORY_IDS = '4bf58dd8d48988d163941735,4bf58dd8d48988d1e0931735,4bf58dd8d48988d1a7941735,4bf58dd8d48988d12f941735';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = json_decode(file_get_contents(
            $this::ENDPOINT_URL
            .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
            .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
            .'&ll=50.8798,4.7005'
            .'&v=20150806&m=foursquare'
            .'&radius=5000'
            .'&intent=checkin'
            .'&categoryId='.$this::CATEGORY_IDS
            .'&near='.$this::LOCATION))->response;

        $venues = $response->venues;

        foreach($venues as $venue){
            
            $geo = DB::table('geolocations')->where('longitude',$venue->location->lng)
                ->where('latitude',$venue->location->lat)->first();
            DB::table('places')->insert([['name' => $venue->name,
                                          'geoId' => $geo->id,
                                          'foursquareId' => $venue->id]]);
        }
    }
}