<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    public $timestamps = true;

    public function createdBy(){
        return $this->belongsTo(User::class);
    }

    public function getLocation(){
        return $this->hasOne(Place::class);
    }
}
