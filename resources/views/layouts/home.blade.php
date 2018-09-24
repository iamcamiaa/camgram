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
    <!-- load jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- provide the csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        /*profile photo*/
        #eimg{
             width:200px; 
             height:200px; 
             float:left; 
             border-radius:50%; 
             margin-right:80px;
        }
        .row1 input[type=text]{
            background: transparent;
            border: none;
            border-bottom: 1px solid #000000;
            width: 300px;
        }
        /*edit profile*/
        #eprofile{
            border: 2px solid grey;
            text-decoration: none;
            padding: 5px;
            color: black;
            margin-right: 10px;
            font-size: 20px;
        }
        span{
            font-size: 30px;
            margin-right: 30px;
        }
        #prof{
            height: 30px;
            margin-bottom: 9px;
        }
        /*images*/
        #photoImg{
            width: 350px;
            height: 250px;
        }
        * {
        box-sizing: border-box;
        }
        /* Create three equal columns that floats next to each other */
        .column {
            float: left;
            width: 33.33%;
            padding: 10px;
        }
        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        /*single image modal*/
        #photoSImg{
            width: 600px;
            height: 500px;
        }
        /*model content*/
        #content{
            height: 35pc;
            width: 70pc;
            padding: 10px;
            margin-left: -300px;
        }
        h4{
            margin-left: -30px;
        }
        /*photo modal content*/
        #section{
            margin-left: 58%;
            margin-top: -47%;
            height: 31.3pc;
        }
        #pimg{
            width:50px;
            height:50px; 
            border-radius:50%;
            margin-top: 5px;
            margin-left: 10px;
        }
        #uname{
            margin-left: 70px;
            margin-top: -40px;
        }
        #date{
            margin-left: 48px;
            margin-top: -10px;
        }
        #line{
            margin-top: -15px; 
        }
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
            margin-right: 10px;
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
            margin-top: 15px;
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
        .modal-title{
            margin-left: 1px;
        }
        label{
            margin-left: 30px;
        }
        #info_user{
            font-size: 20px;
            text-indent: 1.5pc;
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
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Home
                </a>
                <a class="navbar-brand" href="#">
                    Notification
                </a>
                <a class="navbar-brand" href="#">
                    Messages
                </a>
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
</body>
</html>
