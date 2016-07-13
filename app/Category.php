<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','foursquareId','icon'];

    public function places(){
    	return $this->hasMany(Place::class);
    }

}
