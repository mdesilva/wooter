<!DOCTYPE html>
<html>
<head>
 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="__token" content="{{ csrf_token() }}">
      {!! assetic('js', 'vendors.jquery', true) !!}
      <input type="hidden" name="jwttoken">
	<title>This is Test for JWT</title>

	YOUR TOKEN IS :     {{$token}}
</head>
<body>
<div> The response should be below</div>
<div id="res"></div>

<button id="run">RUN</button>

<hr/>
<div id="err"></div>
<hr/>
<hr/>
<h1>Register Output</h1>
<div id="register"></div>
<h1>Register Error</h1>
<div id="register_error"></div>

<script type="text/javascript">

$("#run").click(function(){

			  $.ajax({
		  url: "{{url('api/leagues/1/season-weekday-timeslots/3')}}",
		  beforeSend: function (request)
            {
                request.setRequestHeader("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL3dvb3phcmQuZGV2XC9hcGlcL2p3dHRlc3QiLCJpYXQiOjE0NjEwNTIzMDMsImV4cCI6MTQ2MTEzODcwMywibmJmIjoxNDYxMDUyMzAzLCJqdGkiOiJmNTk2ZGU0ZjJlMzBiMWZkNDRlNDM4NTE5YzQxZjIwOSJ9.PWMMSL_Vne6-hHJiqjWCOheTstij1shDI7Ljj-sMtd4");
            },
		  method: "GET",
		  data: 
		  {
		  	'token':"{{$token}}",
		  	// 'league_season_id':"1",
		  	// 'weekday_id':"2",
		  	// 'starts_at':"19:35",
		  	// 'finish_at':"20:35",
		  	// 'league_game_venue_id':"1"
		  }
			}).done(function(res) {
			  $("#res").html( res);
			}).fail(function(resp)
			{
				$("#err").html(resp.responseText);
			});
	
	
});


 // $.ajax({
	// 	  url: "{{url('register')}}",
	// 	  method: "POST",
	// 	  data: 
	// 	  {

	// 	  }
	// 		}).done(function(res) {
	// 		  $("#register").html( res);
	// 		}).fail(function(resp)
	// 		{
	// 			$("#register_error").html(resp.responseText);
	// 		});
</script>
</body>
</html>