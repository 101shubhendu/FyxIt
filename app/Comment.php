<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{   protected $hidden = ['approved','post_id'];
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function likes()
    {
        return $this->morphToMany('App\User', 'likeable')->whereDeletedAt(null);
    }

    public function getIsLikedAttribute()
    {
        $like = $this->likes()->whereUserId(Auth::id())->first();

        return (! is_null($like)) ? true : false;
    }
}
