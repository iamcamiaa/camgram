<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Photo;
use App\User;
use App\Comment;
use App\Friend;

class UserController extends Controller
{
	//view profile.blade.php
    public function show(){
	    return view('profile', ['user' => Auth::user()] );
	 }
	//update profile info
	public function update_avatar(Request $request){
    $null = $request->toArray();
    $arr = array_filter($null); 
    $arr = array_except($arr, ['_token']);
        //updating profile photo
        if($request->hasFile('profile')){
            $files = $request->file('profile');
            $origextension = $files->getClientOriginalExtension();
            $origname = $files->getClientOriginalName();
            $filename = pathinfo($origname, PATHINFO_FILENAME);
            $storefile = $filename.'-'.time().'.'.$origextension;
            $files->storeAs('public/picture', $storefile);
            $user = Auth::user();
            $user->avatar = $storefile;
            $user->save();
            $arr = array_except($arr, ['profile']);
        }
        //updating profile information
        foreach($arr as $val=>$value){
            $user = Auth::user();
            $user->$val = $value;
            $user->save();
        }
        return view('profile', ['user' => Auth::user()] );
    }
    //file upload to database
    public function uploadphoto(Request $request){

      if($request->hasFile('imgInp')){
          $files = $request->file('imgInp');
          $origextension = $files->getClientOriginalExtension();
          $origname = $files->getClientOriginalName();
          $filename = pathinfo($origname, PATHINFO_FILENAME);
          $storefile = $filename.'-'.time().'.'.$origextension;
          $files->storeAs('public/picture', $storefile);
          if($request->has('caption')){
            $photo = new Photo();
            $photo->userid = Auth::id();
            $photo->filename = $storefile;
            $photo->caption = $request->caption;
            $photo->save();
          }else{
            $photo = new Photo();
            $photo->userid = Auth::id();
            $photo->filename = $storefile;
            $photo->save();
          }
          return Redirect::back()->with('successUpload', true);    
      }  
    }
    //profile homepage
    public function home($id){
      $photo = Photo::where('userid', $id)->orderByDesc('created_at')->get();
      $user = User::find($id);
      return view('homeprofile')->with(['photo'=>$photo, 'user'=>$user]);
    }
    //add comment
    public function comment(Request $request){
      $comment = new Comment();
      $comment->photoid = $request->photoid;
      $comment->userid = Auth::id();
      $comment->comment = $request->comment;
      $comment->save();
      $response = array(
          'status' => $request->photoid,
      );
      return response()->json($response); 
    }
    //all comment per photo
    public function allcomment(Request $request){
      $comment = Comment::where('photoid', $request->photoid)->get();
      $collection = new Collection();
      foreach($comment as $com){
          $user = User::find($com->userid);
          $comval['username'] = $user->username;
          $comval['comment'] = $com->comment;
          $comval['photoid'] = $com->photoid;
          $collection->push($comval);
      }
      return response()->json($collection);
    }
    //find friend
    public function addfriends(){
      $userAcc = User::where('id','!=', Auth::id())->get();
      $user = new Collection();
      foreach($userAcc as $account){
        $friend = Friend::where('userid',Auth::id())->where('friend', $account->id)->get();
        if($friend->count() == 0){
          $user->push($account);
        }
      }
      return view('addfriends')->with(['user'=>$user]);
    }
    //add friend
    public function added(Request $request){
      $friends = new Friend();
      $friends->userid = Auth::id();
      $friends->friend = $request->friendid;
      $friends->save();
      // update friends list
      $userAcc = User::where('id','!=', Auth::id())->get();
      $user = new Collection();
      foreach($userAcc as $account){
        $friend = Friend::where('userid',Auth::id())->where('friend', $account->id)->get();
        if($friend->count() == 0){
          $account['count'] = $account->photo->count();
          $account['friends'] = $account->friend->count();
          $account['followers'] = $account->friend_follow->count();
          $user->push($account);
        }
      }
      return $user;
    }
    //search
    public function search(Request $request){
      //returning only the first search row
      $search = $request->search;
      $user = User::where('username', $search)->orWhere('fname', $search)->orWhere('lname', $search)->first();
      
      if($user == null){
        return Redirect::back()->with('none', true);
      }else{
        $id = $user->id;
        $photo = Photo::where('userid', $id)->orderByDesc('created_at')->get();
        $user = User::where('id', $id)->get();
        return view('homeprofile')->with(['photo'=>$photo, 'user'=>$user]);
      }
    }
}
