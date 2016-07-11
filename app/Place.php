<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['longitude','latitude','name'];
    public $incrementing = false;

    public function checkins(){
    	return $this->hasMany(Checkin::class);
    }

    public function photos(){
    	return $this->hasMany(Phot::class);
    }

    public $timestamps = false;
}
