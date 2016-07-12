<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Debugbar;
use Cache;

class FoursquareProvider
{
    const URL = 'https://api.foursquare.com/v2/venues/';
    const CACHE_TIME = 60;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function getPlaceById($id)
    {
        $key = $this->getCacheKey($id);
        if(Cache::has($key))
        {
            return Cache::get($key);
        } else {
            $details = [
            'client_id' => env('FOURSQUARE_API_KEY'),
            'client_secret' => env('FOURSQUARE_API_ID')
            ];
            $place = json_decode(file_get_contents(
                'https://api.foursquare.com/v2/venues/50655812e4b07b9787f62cdf'
                .'?client_id='.env('FOURSQUARE_CLIENT_ID').'&client_secret='.env('FOURSQUARE_CLIENT_SECRET').'&v=20150806'
                ));
            Cache::add($key, $place, $this::CACHE_TIME);
            return $place;
        }

    }

    private function getCacheKey($foursquareId)
    {
        return 'foursquare-venue-' . $foursquareId;
    }

    public function buildUrl($details)
    {

    }
}
