<?php
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
//confirm email
Route::get('users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');
route::middleware(['auth'])->group(function(){
//login
Route::get('/home', 'HomeController@index')->name('home');
//update profile
Route::get('/showprofile', 'UserController@show');
Route::post('/updateprofile', 'UserController@update_avatar')->name('profile.update');
Route::get('/profile/{id}', 'UserController@home');
//upload photo
Route::post('/upload', 'UserController@uploadphoto')->name('upload');
//comment
Route::post('/comment', 'UserController@comment')->name('comment');
Route::post('/allcomment', 'UserController@allcomment')->name('allcomment');
//friend
Route::get('/addfriends','UserController@addfriends')->name('addfriends');
Route::post('/added', 'UserController@added')->name('added');
//search
Route::get('/search', 'UserController@search')->name('search');
});
