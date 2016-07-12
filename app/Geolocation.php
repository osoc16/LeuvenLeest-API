<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geolocation extends Model
{
	protected $fillable = ['longitude','latitude'];

	public function place(){
		return $this->belongsTo('Place');
	}

	public function checkins(){
		return $this->belongsTo(Checkin::class);
	}
}
