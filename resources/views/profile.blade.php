@extends('layouts.app')
<style>
    #eimg{
         width:150px; 
         height:150px; 
         float:left; 
         border-radius:50%; 
         margin-right:25px;
    }
    .row1 input[type=text]{
        background: transparent;
        border: none;
        border-bottom: 1px solid #000000;
        width: 300px;
        outline: none;
    }
</style>
@section('content')
<div class="container">
<form enctype="multipart/form-data" action="{{ route('profile.update') }}" method="POST">{{csrf_field()}}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        @if(url('storage/picture/'.$user->avatar) != null)
            <img src="{{url('storage/picture/'.$user->avatar)}}" id="eimg">
            <h2>{{ $user->fname }}'s Profile</h2>
        @else
            <h2>Add Profile Photo</h2>
        @endif
            <input type="file" name="profile">
            <input type="submit" class="pull-right btn btn-sm btn-primary">
        </div>
    </div><br><br><br>
    <h2>Edit Profile</h2>
    <div class="row1">
    <table>
    <col width="130">
    <col width="80">
        <tr>
            <td>Username:</td>
            <td><input type="text" name="username"></td>
        </tr>
        <tr>
            <td>First Name:</td>
            <td><input type="text" name="fname"></td>
        </tr>
        <tr>
            <td>Last Name:</td>
            <td><input type="text" name="lname"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="text" name="email"></td>
        </tr>
    </table>
    </div>
 </form>
</div>
@endsection