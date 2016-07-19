<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['name'];

	public function place(){
		return $this->belongsTo(Place::class);
	}

	public function uploadedBy(){
		return $this->belongsTo(User::class);
	}
}
