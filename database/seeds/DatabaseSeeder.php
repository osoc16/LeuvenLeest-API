<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use App\Place;
use App\OpeningHours;
use Carbon\Carbon;

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
        $this->call(CategorySeeder::class);
        $this->call(PlaceSeeder::class);
        $this->call(OpeningHoursSeeder::class);
        $this->call(QuestionSeeder::class);
    }
}

class GeolocationSeeder extends Seeder
{

    const ENDPOINT_URL = 'https://api.foursquare.com/v2/venues/search';
    const LOCATION = 'Leuven';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['4bf58dd8d48988d163941735','4bf58dd8d48988d1e0931735','4bf58dd8d48988d1a7941735','4bf58dd8d48988d12f941735'];
        foreach($categories as $category){  
            $response = json_decode(file_get_contents(
                $this::ENDPOINT_URL
                .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
                .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
                .'&ll=50.8798,4.7005'
                .'&v=20150806&m=foursquare'
                .'&radius=5000'
                .'&intent=checkin'
                .'&categoryId='.$category
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
        $now = Carbon::now();
        DB::table('categories')->insert([['name' => 'park', 'foursquareId' => '4bf58dd8d48988d163941735', 'icon' => 'null', 'created_at' => $now, 'updated_at' => $now],
                                             ['name' => 'coffee shop', 'foursquareId' => '4bf58dd8d48988d1e0931735', 'icon' => 'null', 'created_at' => $now, 'updated_at' => $now],
                                             ['name' => 'college library', 'foursquareId' => '4bf58dd8d48988d1a7941735', 'icon' => 'null', 'created_at' => $now, 'updated_at' => $now],
                                             ['name' => 'library', 'foursquareId' => '4bf58dd8d48988d12f941735', 'icon' => 'null', 'created_at' => $now, 'updated_at' => $now]]);
    }
}

class PlaceSeeder extends Seeder
{

    const ENDPOINT_URL = 'https://api.foursquare.com/v2/venues/search';
    const LOCATION = 'Leuven';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['4bf58dd8d48988d163941735','4bf58dd8d48988d1e0931735','4bf58dd8d48988d1a7941735','4bf58dd8d48988d12f941735'];
        foreach($categories as $category){
            $response = json_decode(file_get_contents(
                $this::ENDPOINT_URL
                .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
                .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
                .'&ll=50.8798,4.7005'
                .'&v=20150806&m=foursquare'
                .'&radius=5000'
                .'&intent=checkin'
                .'&categoryId='.$category
                .'&near='.$this::LOCATION
                .'&limit=50'))->response;

            $venues = $response->venues;

            foreach($venues as $venue){

                $fullvenue = json_decode(file_get_contents(
                'https://api.foursquare.com/v2/venues/'.$venue->id
                .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
                .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
                .'&v=20150806&m=foursquare'))->response->venue;
                
                $exists = DB::table('geolocations')->where('longitude',$venue->location->lng)
                    ->where('latitude',$venue->location->lat)->get();
                if(!$exists){
                    DB::table('geolocations')->insert([['latitude' => $venue->location->lat,
                                                        'longitude' => $venue->location->lng]]);
                }

                $geo = DB::table('geolocations')->where('longitude',$fullvenue->location->lng)
                    ->where('latitude',$fullvenue->location->lat)->first();

                $catfoursquareid = $fullvenue->categories[0]->id;
                $description = property_exists($fullvenue,'description') ? $fullvenue->description : '';
                $category = DB::table('categories')->where('foursquareId',$catfoursquareid)->first();
                $categoryid = is_object($category) ? $category->id : null;
                $url = property_exists($fullvenue, 'url') ? $fullvenue->url : '';
                $description = property_exists($fullvenue, 'description') ? $fullvenue->description : '';

                $place = new Place();
                $place->name = $fullvenue->name;
                $place->geoId = $geo->id;
                $place->foursquareId = $fullvenue->id;
                $place->description = $description;
                $place->email = '';
                $place->site = $url;
                $place->categoryId = $categoryid;
                $place->address = $fullvenue->location->formattedAddress[0];
                $place->save();
            }
        }

        //Add places that were tipped by cultuurconnect: abdij Keizersberg; dijlepark; dijleterassen
        //park den bruul; hogeschoolplein; sint-geertrui abdij
        $neededvenueIds = ['4ca5ea3914c337047240ba3b','4ddac32db0fb97d348b86ec3','4c28ebb09eb1952164a12959','4c379cb9dfb0e21e0e1dada8','4bf1725f408ec9287de66600','54cd4d0f498e263faa9f1571'];
        foreach($neededvenueIds as $id){
            $fullvenue = json_decode(file_get_contents(
                'https://api.foursquare.com/v2/venues/'.$id
                .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
                .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
                .'&v=20150806&m=foursquare'))->response->venue;

            $placeExists = DB::table('places')->where('foursquareId',$id)->get();
            if(!$placeExists){
                $exists = DB::table('geolocations')->where('longitude',$fullvenue->location->lng)
                        ->where('latitude',$fullvenue->location->lat)->get();
                if(!$exists){
                    DB::table('geolocations')->insert([['latitude' => $fullvenue->location->lat,
                                                        'longitude' => $fullvenue->location->lng]]);
                }

                $geo = DB::table('geolocations')->where('longitude',$fullvenue->location->lng)
                    ->where('latitude',$fullvenue->location->lat)->first();
                $catfoursquareid = $fullvenue->categories[0]->id;
                $description = property_exists($fullvenue,'description') ? $fullvenue->description : '';
                $category = DB::table('categories')->where('foursquareId',$catfoursquareid)->first();
                $categoryid = is_object($category) ? $category->id : null;
                $url = property_exists($fullvenue, 'url') ? $fullvenue->url : '';
                $description = property_exists($fullvenue, 'description') ? $fullvenue->description : '';

                $place = new Place();
                $place->name = $fullvenue->name;
                $place->geoId = $geo->id;
                $place->foursquareId = $fullvenue->id;
                $place->description = $description;
                $place->email = '';
                $place->site = $url;
                $place->categoryId = $categoryid;
                $place->address = $fullvenue->location->formattedAddress[0];
                $place->save();
            }
        }

    }
}

class OpeningHoursSeeder extends Seeder
{
    const MINUTES_PER_HOUR = 60;
    const DIVISION_UNIT = 15; //quarters of hours
    const HOURS_IN_A_DAY = 24;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalHourStringLength = self::HOURS_IN_A_DAY*(self::MINUTES_PER_HOUR/self::DIVISION_UNIT);
        $places = DB::table('places')->get();
        foreach($places as $place){
            $hours = json_decode(file_get_contents(
                'https://api.foursquare.com/v2/venues/'.$place->foursquareId.'/hours'
                .'?client_id='.env('FOURSQUARE_CLIENT_ID','')
                .'&client_secret='.env('FOURSQUARE_CLIENT_KEY','')
                .'&v=20150806&m=foursquare'))->response->hours;

            if(property_exists($hours, 'timeframes')){
                foreach($hours->timeframes as $timeframe){
                    foreach($timeframe->days as $day){
                        $openinghours = new OpeningHours();
                        $openinghours->placeId = $place->id;
                        $openinghours->dayOfWeek = $day;
                        $hourstring = '';
                        foreach($timeframe->open as $open){
                            $starthour =  intdiv(intval($open->start),100);
                            $startminutes = intval($open->start)%100;
                            $bitstart = (($starthour*self::MINUTES_PER_HOUR)+$startminutes)/self::DIVISION_UNIT;
                            $hourstring .= str_repeat('0', $bitstart-strlen($hourstring));
                            $endhour = intdiv(intval($open->end),100);
                            $endminutes = intval($open->end)%100;
                            if($endhour == 0 && $endminutes == 0){
                                $endhour = 24;
                            }
                            $bitend = (($endhour*self::MINUTES_PER_HOUR)+$endminutes)/self::DIVISION_UNIT;
                            $hourstring .= str_repeat('1', $bitend-$bitstart);
                        }
                        $remainder = $totalHourStringLength-strlen($hourstring);
                        $hourstring .= str_repeat('0', $remainder);
                        $openinghours->hours = $hourstring;
                        $openinghours->save();
                    }
                }
            }
        }
    }
}

class QuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->insert([['question' => 'Is de plaats afgelegen of druk?'],
                                        ['question' => 'Is de plaats stil of luid?'],
                                        ['question' => 'Is de plaats groen of stedelijk?'],
                                        ['question' => 'Is de plaats rustig of levendig?']]);

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
