<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Collection;
use App\Photo;
use App\Comment;
use App\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //home.blade.php
        $user = User::all();
        $collection = new Collection();
        foreach($user as $username){
            $photo = Photo::where('userid', $username->id)->orderByDesc('created_at')->get();
            foreach($photo as $img){
                $comment = Comment::where('photoid', $img->photoid)->get();
                $arr = array(
                    'user' => $username,
                    'image' => $img,
                    'comments' => $comment,
                );
                $collection->push($arr);
            }
        }
        return view('home')->with(['collection'=>$collection]);
    }
}
