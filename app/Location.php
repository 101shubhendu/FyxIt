<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $hidden = ['created_at','updated_at','id'];

    public function post(){
        return $this->belongsTo('App\Post');
    }
}
