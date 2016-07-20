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
        $this->call(CategorySeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(QuestionSeeder::class);
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

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('categories')->insert([['name' => 'park', 'foursquareId' => '4bf58dd8d48988d163941735', 'icon' => 'null'],
                                             ['name' => 'coffee shop', 'foursquareId' => '4bf58dd8d48988d1e0931735', 'icon' => 'null'],
                                             ['name' => 'college library', 'foursquareId' => '4bf58dd8d48988d1a7941735', 'icon' => 'null'],
                                             ['name' => 'library', 'foursquareId' => '4bf58dd8d48988d12f941735', 'icon' => 'null']]);
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

            $fullvenue = json_decode(file_get_contents(
            'https://api.foursquare.com/v2/venues/'.$venue->id
            .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
            .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
            .'&ll=50.8798,4.7005'
            .'&v=20150806&m=foursquare'
            .'&radius=5000'
            .'&intent=checkin'
            .'&categoryId='.$this::CATEGORY_IDS
            .'&near='.$this::LOCATION))->response->venue;


            $geo = DB::table('geolocations')->where('longitude',$fullvenue->location->lng)
                ->where('latitude',$fullvenue->location->lat)->first();

            $catfoursquareid = $fullvenue->categories[0]->id;
            $description = property_exists($fullvenue,'description') ? $fullvenue->description : '';
            $category = DB::table('categories')->where('foursquareId',$catfoursquareid)->first();
            $categoryid = is_object($category) ? $category->id : null;
            $url = property_exists($fullvenue, 'url') ? $fullvenue->url : '';



            DB::table('places')->insert([['name' => $fullvenue->name,
                                          'geoId' => $geo->id,
                                          'foursquareId' => $fullvenue->id,
                                          'description' => '',
                                          'email' => '',
                                          'site' => $url,
                                          'categoryId' => $categoryid,
                                          'address' => $fullvenue->location->formattedAddress[0]]]);
        }
    }
}

class QuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([['question' => 'one'],
                                        ['question' => 'two'],
                                        ['question' => 'three'],
                                        ['question' => 'four']]);

        $places = DB::table('places')->get();
        foreach($places as $place)
        {
            for ($i = 1; $i <= 4; $i++)
            {
                DB::table('evaluations')->insert([['placeId' => $place->id,
                                                   'questionId' => $i,
                                                   'ratingGood' => 0,
                                                   'ratingBad' => 0,
                                                   'votes' => 0]]);
            }
        }
    }
}
