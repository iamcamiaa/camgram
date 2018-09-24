@extends('layouts.home')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="{{url('storage/picture/'.$user->avatar)}}" id="eimg">
            <span><label>@</label>{{ $user->username }}</span>
            @if(Auth::id() == $user->id)
            <a href="{{ url('showprofile') }}" id="eprofile">Edit Profile</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img id="prof" src="{{  url('storage/picture/logout.png')}}"></a><form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form><br>
            @endif
            <p id="info_user">&#8196;{{$user->photo->count()}} posts {{$user->friend->count()}} following {{$user->friend_follow->count()}} followers</p>
        </div>
    </div><br><br><br>
    <div class="row">
        @foreach($photo as $img)
          <div class="column">
          <a href="#" data-toggle="modal" data-target="#p{{$img->photoid}}"><img id="photoImg" src="{{  url('storage/picture/'.$img->filename)}}"></a>
          </div>
          <!-- modal -->
          <div class="modal fade" id="p{{$img->photoid}}" role="dialog" >
            <div class="modal-dialog" >
              <div class="modal-content" id="content">
                <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <img id="photoSImg" src="{{  url('storage/picture/'.$img->filename)}}">
                <div id="section">
                    <img src="{{url('storage/picture/'.Auth::user()->avatar)}}" id="pimg">
                    <h4 id="uname">{{Auth::user()->username}}</h4>
                    <ul><li id="date">{{ $img->created_at->format('M d, Y') }}</li></ul>
                    <p id="line">______________________________________________________________</p>
                    @if(isset($img->caption))
                    <h4><label>{{Auth::user()->username}} {{ $img->caption }}</label></h4>
                    @endif
                    <p id="captionlist{{$img->photoid}}">
                    <!-- all comments here... -->
                    </p>
                    <input id="comment{{$img->photoid}}" type="text" name="comment{{$img->photoid}}" placeholder="Comment..." style="background: transparent;border: none;width: 320px;outline: none;font-size: 20px;">
                    <button id="sub{{$img->photoid}}" style="border-radius: 20px;background-color: #82ccdd;border: 2px solid #82ccdd;outline: none;font-weight: bolder;color: white;height: 40px;">Add Comment</button>
                </div>
                </div>
              </div>
            </div>
          </div>
        <!-- endmodal -->
<script>
// check database every 2 seconds if has new comment/s
function single{{$img->photoid}}(){
var text_{{$img->photoid}} = '';
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajax({
    url: '/allcomment',
    type: 'POST',
    data: {_token: CSRF_TOKEN, photoid:{{$img->photoid}}},
    dataType: 'JSON',
    success: function (data){
        for (var i = 0; i < data.length; i++) {
            text_{{$img->photoid}}+= `<h4><label>`+data[i].username+` `+data[i].comment+`</label></h4>`;
        }$('#captionlist{{$img->photoid}}').html(text_{{$img->photoid}});
    }
}); 
}
setInterval(single{{$img->photoid}}, 2000);
</script>

<script>
        $(document).ready(function(){
            var commentbox = '';
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#sub{{$img->photoid}}").click(function(){
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/comment',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, comment:$("#comment{{$img->photoid}}").val(),photoid:{{$img->photoid}}},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        single{{$img->photoid}}();
                        $('#comment{{$img->photoid}}').val(commentbox);
                    }
                }); 
            });
        });    
</script>
        @endforeach

    </div>
</div>
@endsection