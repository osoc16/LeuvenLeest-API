<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function checkins(){
        return $this->hasMany(Checkin::class);
    }

    public function places(){
        return $this->hasMany(Place::class);
    }

    public function favourites(){
        return $this->hasMany('App\Place','favourites','placeId','userId')->withTimestamps();
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }
}
