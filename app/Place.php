<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['foursquareId','geoId','name','address','userId','email','categoryId','site'];
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

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function getCategory(){
        return $this->belongsTo(Category::class);
    }
}
