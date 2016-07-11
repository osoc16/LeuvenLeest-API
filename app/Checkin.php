<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = ['longitude','latitude'];

    public function place(){
    	return $this->belongsTo(Place::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}
