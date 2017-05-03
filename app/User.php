<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','pivot'
    ];

//    $user = App\User::find(1);
//    $token = $user->createToken('Token Name')->accessToken;

    public function posts() {

        return $this->hasMany('App\Post');
    }

    public function likedPosts()
    {
        return $this->morphedByMany('App\Post', 'likeable')->whereDeletedAt(null);
    }
    public function likeComments()
    {
        return $this->morphedByMany('App\Comment', 'likeable')->whereDeletedAt(null);
    }
}
