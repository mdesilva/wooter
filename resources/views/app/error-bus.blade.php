<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Our app have some problems!</title>
		
		<link rel="stylesheet" href="{{ asset('css/vendors/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('css/vendors/font-awesome.css') }}">
		<link rel="stylesheet" href="{{ asset('css/error.css') }}">
		<link href="http://fonts.googleapis.com/css?family=Raleway:400,200,300,500,700" rel="stylesheet" type="text/css">
		
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="pg">			
			<span class="icon"><a href="{{ url('/') }}" title="Go to Home">{!! entypo('emoji-sad') !!}</a></span>
			
			<h1>Sorry we've experienced some technical problems, please try again later.</h1>
			<h2>Copyright {{ date('Y') }} by Wooter  |  <a href="mailto:vip@wooter.co">vip@wooter.co</a></h2>
		</div>
		<script src="{{ asset('js/vendors/jquery/index.js') }}"></script>
		<script src="{{ asset('js/vendors/bootstrap/index.js') }}"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(window).load(function() {
					$('div.pg').fadeIn(700);
				});
				setTimeout(function(){
					function colBG(){
						var colors = ['16a085','2ecc71','27ae60','3498db','2980b9','34495e','2c3e50','ea4c88','ca2c68','9b59b6','8e44ad','f1c40f','f39c12','e74c3c','c0392b','bdc3c7','95a5a6','7f8c8d'];
						$('body').css('background', '#'+colors[Math.floor(Math.random()*colors.length)]);
					}
					colBG();
					var interval = setInterval(colBG, 5000);
				}, 500);

			});
		</script>
	</body>
</html>