<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname','lname','username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function photo(){
        return $this->hasMany('App\Photo', 'userid', 'id');
    }
    public function comment(){
        return $this->hasMany('App\Comment', 'userid', 'id');
    }
    public function friend(){
        return $this->hasMany('App\Friend', 'userid', 'id');
    }
    public function friend_follow(){
        return $this->hasMany('App\Friend', 'friend', 'id');
    }
}
