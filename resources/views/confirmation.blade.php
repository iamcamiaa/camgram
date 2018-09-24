

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>

	#box{
		width: 35%;
		margin: auto; 
		height: 11cm;
	}
	#innerbox{
		margin: auto;
		background-color: #0984e3;
		height: 70px;
		width: 100%;

	}
	#line{
		border: 2px solid #dfe6e9;
		width: 250px;
		margin: auto; 
	}
	#header{
		text-align: center;
		color: #dfe6e9; 
		font-size: 20px;
		font-weight: bold;
		padding: 5px;

	}
	#greetings{
		font-size: 15px;
		color: black;
	}
	#first{
		font-weight: lighter;
		font-size: 15px;
		color: black;
	}
	#note{
		color: black;
		font-size: 15px;
	}
	#link{
		padding: 5px;
		font-size: 15px;
		border-radius: 50%;
		border: 3px solid #0984e3;
		background-color: #0984e3;
		border-radius: 2px;
		color: white;
		text-decoration: none;
	}
	#note1{
		color: black;
		font-size: 15px;
		margin-top: 20px;
	}

</style>
</head>
<body>
<div id="box">
	<div id="innerbox">
		<p id="header">WELCOME TO CAMGRAM</p>
		<div id="line"></div>
	</div><br>
		<div id="greetings">&nbsp;Dear {{$fname}} {{$lname}},</div>

		<div id="first">
			&emsp;&emsp;&emsp;You're receiving this message because you signed up for an account on CAMGRAM.</div>

			<center><div id="note">(If you didn't sign up, you can ignore this email.)</div></center><br>

		<center><a href="{{ route('confirmation', $token)}}" id="link">Confirm your Email</a></center>

		<center><div id="note1">or confirm your email by clicking:</div></center>
		<center><br>{{ route('confirmation', $token)}}</center><br><br>
</div>
</body>
</html>


