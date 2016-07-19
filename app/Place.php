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
    	return $this->hasMany(Photo::class,'placeId','id');
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

    public function isFavouriteFrom(){
        return $this->belongsToMany('App\User','favourites','placeId','userId')->withTimestamps();
    }

    public function openingHours(){
        $this->hasMany(OpeningHours::class,'placeId','id');
    }
}
