<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
	protected $fillable = ['geoId'];

    public function place(){
    	return $this->belongsTo(Place::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function getLocation(){
    	return $this->hasOne(Geolocation::class);
    }
}
