<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geolocation extends Model
{
	protected $fillable = ['longitude','latitude'];
    public $timestamps = false;


	public function place(){
		return $this->belongsTo(Place::class);
	}

	public function checkins(){
		return $this->belongsTo(Checkin::class);
	}
}
