<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{    protected $visible = ['id','name','email'];
    use SoftDeletes;
    protected $table = 'likeables';
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];
//    public function user()
//    {
//        return $this->belongsTo('App\User', 'user_id');
//    }
    /**
     * Get all of the products that are assigned this like.
     */
    public function comments()
    {
        return $this->morphedByMany('App\Comment', 'likeable');
    }

    /**
     * Get all of the posts that are assigned this like.
     */
    public function posts()
    {
        return $this->morphedByMany('App\Post', 'likeable');
    }
}
