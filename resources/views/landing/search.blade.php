<section id="how_works">
		<a href="#how_works" class="btn x-close fa fa-remove"></a>
		<div class="container">
			<div class="col-sm-4 sector">
				<div class="img">
					<i class="fa fa-search" aria-hidden="true"></i>
				</div>
				
				<h1 class="no">1</h1>
				<div class="hr_custom"></div>
				<h1>Find a League</h1>				
			</div>
			
			<div class="col-sm-4 sector">
				<div class="img">
					<i class="fa fa-check-square-o" aria-hidden="true"></i>
				</div>
				
				<h1 class="no">2</h1>
				<div class="hr_custom"></div>
				<h1>Register your team</h1>				
			</div>
			
			<div class="col-sm-4 sector">
				<div class="img">
					<i class="fa fa-play" aria-hidden="true"></i>
				</div>
				
				<h1 class="no">3</h1>
				<div class="hr_custom"></div>
				<h1>Go Play</h1>				
			</div>
			<div class="col-sm-12">
				<p>Sign up to start, run and grow your league with Wooter.</p>
			</div>
		</div>
</section>

@extends('landing.layout.page')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<h1>Find Sports Leagues Near You</h1>
		<p>Just search, book, and play!</p>
		<a href="#" class='how'><button class="yellow_btn md-whiteframe-4dp">How It Works</button></a>
	</div>
</div>

<div class="input_section">
	<div class="input_text">
		<p><i class="fa fa-search" aria-hidden="true"></i></p>
		<input type="text">
		<button class="search yellow_btn">Search</button>
		<div class="clear"></div>
	</div>
</div>

<div class="white_separator_origin space_one" style="padding-bottom: 48px;">
	<div class="white_separator_3 popup_one">	

		<div class="pricing_text">
			<h1>Dream Leagues Near You</h1>
			<div class='custom_hr'></div>
		</div>	
		
		<div class="ws_margin ">
			<div class="ws md-whiteframe-4dp">
	        	<div class='league_results'>
	        		<div class='league_desc' style=''>
	        			<p>Dream Leagues 8.5<br><span>Staten Island, NY<span></p>
	        		</div>
	        	</div>

				<div class="league">
					<img src="/img/landings/home-leagues1.png" alt="">
				</div>
				<div class="white_info">
	        		<p class='ls_left'>Registration Closes: 5/26</p>
	        		<p class='ls_right'><a class='signup_button' target='_blank' href="https://airtable.com/shrHquD8j7Gn94uBt">JOIN NOW</a></p>
	        		<div class="clear"></div>
				</div>
			</div>

			<div class="ws md-whiteframe-4dp">
	        	<div class='league_results'>
	        		<div class='league_desc' style=''>
	        			<p>Dream Leagues NYC Premier League<br><span>Manhattan, NY<span></p>
	        		</div>
	        	</div>

				<div class="league">
					<img src="/img/landings/home-leagues2.png" alt="">
				</div>
				<div class="white_info">
	        		<p class='ls_left'>Registration Closes: 6/16</p>
	        		<p class='ls_right'><a class='signup_button' target='_blank' href="https://airtable.com/shrVV9qcHO0EtZCvq">JOIN NOW</a></p>
	        		<div class="clear"></div>
				</div>
			</div>

			<div class="ws md-whiteframe-4dp">
	        	<div class='league_results'>
	        		<div class='league_desc' style=''>
	        			<p>Pacplex Streetball 3v3<br><span>Brooklyn, NY<span></p>
	        		</div>
	        	</div>

				<div class="league">
					<img src="/img/landings/home-leagues3.png" alt="">
				</div>
				<div class="white_info">
	        		<p class='ls_left'>Registration Closes: 7/06</p>
	        		<p class='ls_right'><a class='signup_button' target='_blank' href="https://airtable.com/shrpc7IXUkuLSJcSD">JOIN NOW</a></p>
	        		<div class="clear"></div>
				</div>
			</div>

			<div class="ws md-whiteframe-4dp">
	        	<div class='league_results'>
	        		<div class='league_desc' style=''>
	        			<p>Dream Leagues Elite<br><span>Staten Island, NY<span></p>
	        		</div>
	        	</div>

				<div class="league">
					<img src="/img/landings/home-leagues4.png" alt="">
				</div>
				<div class="white_info">
	        		<p class='ls_left'>Registration Closes: 6/30</p>
	        		<p class='ls_right'><a class='signup_button' target='_blank' href="https://airtable.com/shrkJyYzwuiWhpVua">JOIN NOW</a></p>
	        		<div class="clear"></div>
				</div>
			</div>

			<div class="clear"></div>
		</div>

		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<div class="white_button">
	<p><a href="#"><button class='yellow_btn md-whiteframe-4dp'>Load More</button></a></p>
</div>


@stop