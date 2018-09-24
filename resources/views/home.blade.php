@extends('layouts.app')
@section('content')
@foreach($collection as $img)

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- header -->
                <div class="card-header"><a href="{{ url('/profile/'.$img['user']['id']) }}" id="phref"><img src="{{  url('storage/picture/'.$img['user']['avatar'])}}" id="photo_href">{{$img['user']->username}}</a></div>
                <!-- body -->
                <img id="sphoto" class="card-body" src="{{  url('storage/picture/'.$img['image']['filename'])}}">
                <!-- footer -->
                 <div class="card-footer">
                    @if(isset($img['image']['caption']))
                    <h5><b>{{$img['user']->username}}</b> {{$img['image']['caption']}}</h5>
                    @endif
                    <div id="captionlist{{$img['image']['photoid']}}">
                      <!-- comments here... -->
                    </div>
                    <input id="comment{{$img['image']['photoid']}}" type="text" name="comment" placeholder="Comment..." style="background: transparent;border: none;width: 35.5pc;outline: none;font-size: 20px;">
                    <button id="sub{{$img['image']['photoid']}}" style="border-radius: 20px;background-color: #82ccdd;border: 2px solid #82ccdd;outline: none;font-weight: bolder;color: white;height: 40px;">Add Comment</button>
                 </div>
            </div>
        </div>
    </div>
</div><br> 

<script>
// check database every 2 seconds if has new comment/s
function single{{$img['image']['photoid']}}(){
var text_{{$img['image']['photoid']}} = '';
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajax({
    url: '/allcomment',
    type: 'POST',
    data: {_token: CSRF_TOKEN, photoid:{{$img['image']['photoid']}}},
    dataType: 'JSON',
    success: function (data){
        for (var i = 0; i < data.length; i++) {
            text_{{$img['image']['photoid']}}+= `<h5><b>`+data[i].username+`</b> `+data[i].comment+`</h5>`;
        }$("#captionlist{{$img['image']['photoid']}}").html(text_{{$img['image']['photoid']}});
    }
}); 
}
setInterval(single{{$img['image']['photoid']}}, 2000);
</script>
<script>
//save new comment
        $(document).ready(function(){
            var commentbox = '';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#sub{{$img['image']['photoid']}}").click(function(){
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/comment',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, comment:$("#comment{{$img['image']['photoid']}}").val(),photoid:{{$img['image']['photoid']}}},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        single{{$img['image']['photoid']}}();
                        $("#comment{{$img['image']['photoid']}}").val(commentbox);
                    }
                }); 
            });
        });    
</script>
@endforeach
@endsection
