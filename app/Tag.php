<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{   protected $hidden = ['created_at','updated_at','pivot'];
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
