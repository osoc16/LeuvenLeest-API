<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpeningHours extends Model
{
    protected $fillable = ['placeId','dayOfWeek','hours'];

    public function place(){
    	return $this->belongsTo(Place::class);
    }
}
