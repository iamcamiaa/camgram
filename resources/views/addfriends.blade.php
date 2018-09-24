@extends('layouts.friend')
@section('content')
<div class="container">
    <div class="row">
    @if($user->count() != 0)
    @foreach($user as $friend)
        <div class="column">
            <div id="col">
            <a href="{{ url('/profile/'.$friend->id) }}" id="phref"><img src="{{  url('storage/picture/'.$friend->avatar)}}" id="photo_href"></a>
            </div> 
            <div id="values">
            <b><a href="{{ url('/profile/'.$friend->id)}}" id="shref">{{$friend->username}}</a></b><br>
            <b>{{$friend->photo->count()}}</b> posts 
            <b>{{$friend->friend->count()}}</b> following
            <b>{{$friend->friend_follow->count()}}</b> followers <br>
            <button id="addfriend{{$friend->id}}" style="border-radius: 20px;background-color: #82ccdd;border: 2px solid #82ccdd;outline: none;font-weight: bolder;color: white;height: 40px;margin-top: 25px;margin-left: 9pc;">Follow</button>
            </div>
        </div>
    @endforeach
    @else
    <h1 id="nofriend">All are your friends already!</h1>
    @endif
    </div>
</div>
<!-- script -->
@foreach($user as $friend)
<script>
        $(document).ready(function(){
            var text = '';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#addfriend{{$friend->id}}").click(function(){
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/added',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, friendid:{{$friend->id}}},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        //rewrite friend's list
                        if(data.length != 0){
                            for (var i = 0; i < data.length; i++) {
                            text += `
                            <div class="column">
                                        <div id="col">
                                        <a href="{{ url('/profile/'.`+data[i].id+`) }}" id="phref"><img src="{{  url('storage/picture/'.$friend->avatar)}}" id="photo_href"></a>
                                        </div> 
                                        <div id="values">
                                        <b><a href="{{ url('/profile/'.`+data[i].id+`)}}" id="shref">`+data[i].username+`</a></b><br>
                                        <b>`+data[i].count+`</b> posts 
                                        <b>`+data[i].friends+`</b> following
                                        <b>`+data[i].followers+`</b> followers <br>
                                        <button id="addfriend{{$friend->id}}" style="border-radius: 20px;background-color: #82ccdd;border: 2px solid #82ccdd;outline: none;font-weight: bolder;color: white;height: 40px;margin-top: 25px;margin-left: 9pc;">Follow</button>
                                        </div>
                            </div>
                            `;
                            }$('.row').html(text);
                        }else{
                            text += `<h1 id="nofriend">All are your friends already!</h1>`;
                            $('.row').html(text);
                        }
                    }
                }); 
            });
        });    
</script>
@endforeach
<!-- endscript -->
@endsection