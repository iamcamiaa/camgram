<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'commentid';
    public function user(){
    	return $this->hasOne('App\User', 'id', 'userid');
    }
    public function photo(){
    	return $this->hasOne('App\Photo', 'photoid', 'photoid');
    }
}
