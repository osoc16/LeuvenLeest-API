<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['foursquareId','geoId','name'];
    public $timestamps = true;

    public function checkins(){
    	return $this->hasMany(Checkin::class);
    }

    public function photos(){
    	return $this->hasMany(Photo::class);
    }

    public function getLocation(){
    	return $this->hasOne(Geolocation::class);
    }
}
