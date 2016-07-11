<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

const ENDPOINT_URL = 'https://api.foursquare.com/v2/venues/search';
const CLIENT_ID = env('FOURSQUARE_API_ID');
const CLIENT_KEY = env('FOURSQUARE_API_KEY');
const LOCATION = 'Leuven';

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        json_decode(file_get_contents(
    		$this::ENDPOINT_URL
    		.'?client_id='.$this::CLIENT_ID
    		.'&client_secret='.$this::CLIENT_KEY
    		.'&v=20150806&m=foursquare'
    		.'&near='.$this::LOCATION), true);
    }
}