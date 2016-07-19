@extends('landing.layout.page')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<div class="text_half">
			<h1>Dream Leagues</h1>
			<p>Athletes who play in Wooter Dream Leagues</p>
			<p>get advanced statistics, game footage</p> 
			<p>and much more all in the Wooter Athlete App.</p>
			<p class='mobile_p'>Athletes who play in Wooter Dream Leagues
			get advanced statistics, game footage
			and much more all in the Wooter Athlete App.</p>
			<button class="yellow_btn md-whiteframe-4dp"><i class="fa fa-play-circle" aria-hidden="true"></i> Watch Video</button>			
		</div>
		<div class="video_half">
			<img src="/img/landings/phones.png" alt="">
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="white_separator_origin space_one">
	<div class="white_separator_3 popup_one">
		<div class="pricing_text">
			<h1>Dream Leagues Near You</h1>
			<div class='custom_hr'></div>
		</div>


		<div class="ws_margin ">
            @foreach ($special_leagues as $league)
			<div class="ws md-whiteframe-4dp">
	        	<div class='league_results'>
	        		<img alt='Logo for DreamLeagues' src="{{$league->basics->logo->thumbnail_path}}">
	        		<div class='league_desc' style=''>
	        			<p>Dream Leagues<br><span style='color: rgba(255,255,255,.6)'>{{$league->locations()->first()->location->state}}<span></p>
	        		</div>
		        	<div class='league_location'>
		        		<p><i class="fa fa-map-marker"></i> 0.8 mi</p>
		        	</div>
	        	</div>

				<div class="league">
					<img src="/img/landings/nets_splash.png" alt="">
				</div>
				<div class="white_info">
	        		<p class='ls_full'>{{$league->name}}</p>
	        		<p class='ls_left'>Deadline: {{\Carbon\Carbon::parse($league->seasons()->first()->registration_closes_at)->format('d/m/Y')}}</p>
	        		<p class='ls_right'>{{$league->basics->min_age}} - {{$league->basics->max_age}}</p>
				</div>
			
			</div>
            @endforeach

			<div class="clear"></div>
		</div>

		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>


<div class="white_button">
	<p><a href="/demo"><button class='yellow_btn md-whiteframe-4dp'>Load More</button></a></p>
</div>


@stop