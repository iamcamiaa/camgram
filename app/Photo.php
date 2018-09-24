<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $primaryKey = 'photoid';
    public function user(){
    	return $this->hasOne('App\User', 'id', 'userid');
    }
    public function comment(){
    	return $this->hasMany('App\Comment', 'photoid', 'photoid');
    }
}
