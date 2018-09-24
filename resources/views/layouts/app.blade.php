<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Camgram') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <style>
        #addphoto {
            border-radius: 20px;
            background-color: #82ccdd;
            border: 2px solid #82ccdd;
            outline: none;
            font-weight: bolder;
            color: white;
            height: 40px;
            margin-top: 16px;
        }
        #searchbar {
            margin-top: 15px;
            border-radius: 20px;
            border: 2px solid #dfe4ea;
            height: 40px;
            outline: none;
        }
        #pimg{
            width:50px;
            height:50px; 
            border-radius:50%;
            margin-top: 5px;
            margin-left: 10px;
        }
        #img{
            width:400px;
            height:300px; 
            border-style: dashed;
            border-color: grey;
        }
        #navbarDropdown{
            margin-top: 35px;
            outline: none;
        }
        #caption{
            margin-left: 30px;
            background: transparent;
            border: none;
            border-bottom: 1px solid #000000;
            width: 25pc;
            outline: none;
        }
        label{
            margin-left: 30px;
        }
        #sphoto{
            height: 30pc;
            width: 45.5pc;
            padding: 0px;

        }
        #photo_href{
            margin-left: -10px;
            width:40px;
            height:40px; 
            border-radius:50%;
            margin-right: 10px;
            color: black;
        }
        #phref{
            color: black;
            font-size: 15px;
        }
        
    </style>
</head>
<body>

@if(Session::has('successUpload'))
<script>
    alert('Upload Successful');
</script><?php Session::forget('successUpload'); ?>  
@elseif(Session::has('none'))
<script>
    alert('No Results');
</script><?php Session::forget('none'); ?>
@endif
<!-- modal -->
<form enctype="multipart/form-data" action="{{ route('upload') }}" method="POST">
{{csrf_field()}}
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Upload Photo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <center>
              <input type="file" id="imgInp" name="imgInp"/><br><br>
              <img id="img"/>
            </center><br>
            <input id="caption" type="text" name="caption" id="caption" placeholder="Caption...">
            <script>
                function readURL(input) {
              if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('#img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
              }
            }
            $("#imgInp").change(function() {
              readURL(this);
            });
            </script>
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-info" value="Upload">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- endmodal -->
<!-- navigation -->
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                @guest
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Home
                </a>
                @else
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Home
                </a>
                <a class="navbar-brand" href="#">
                    Notification
                </a>
                <a class="navbar-brand" href="#">
                    Messages
                </a>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <div class="search-container">
                                <form action="{{ route('search') }}">
                                  <input id="searchbar" type="text" placeholder="  Search.." name="search">
                                </form>
                            </div>
                                <a href="{{ url('/profile/'.Auth::id()) }}"><img src="{{  url('storage/picture/'.Auth::user()->avatar)}}" id="pimg"></a>
                                <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span class="caret"></span></a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ url('/showprofile') }}" class="dropdown-item">Edit Profile</a>
                                    <a href="{{ route('addfriends') }}" class="dropdown-item">Find Friends</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                             <button id="addphoto" data-toggle="modal" data-target="#modal">Add Photo</button>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
<!-- endnavigation -->
</body>
</html>
