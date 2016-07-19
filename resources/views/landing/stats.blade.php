@extends('landing.layout.page')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<div class="text_half">
			<h1>Dream League Stats</h1>
			<p>The experience of playing in your league <br>
			shouldn’t end when the game ends. <br>
			Sign up for a FREE demo today!</p>
			<a href="#"><button class="yellow_btn md-whiteframe-4dp" data-toggle="modal" data-target="#myModal2">Request A Demo</button></a>
		</div>
		<div class="video_half">
			<img data-toggle="modal" data-target="#myModal" src="/img/landings/video_thumbnail.png" alt="">
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="black_space">
	<div class="black_popup commissioners">
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/dave.png" alt="">
			</div>
			<div class="faq">
				<p>"My favorite part about playing in Dream Leagues is the stats. <br>
				I can finally brag about how well I played, and I have the League Hub to back it up!"</p>
				<p class="red">- Dave Kleyman (Dream Leaguer)</p>
			</div>			
		</div>

		<div class="clear"></div>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one">
		<div class="pricing_text">
			<div class="header_half">
				<h1>Advanced Stats</h1>
				<h1>for Any Sport</h1>					
				<div class="custom_hr"></div>		
			</div>
			<div class='blob_half'>
				<p>Organizers are responsible for the well-being of participants, coaches, officials and spectators. Buying sports insurance is one way to ensure that in the event that accidents do happen there will be financial coverage for the victim and the organization.</p>
				<br><br>
				<p>This coverage is designed for U.S. based teams, leagues, clubs, associates, camps, clinics, lessons, tournaments and events conducting youth or adult amateur sports activities.
				</p>						
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

<div class="white_space space_two">
	<div class="white_popup md-whiteframe-4dp pricing popup_two">
		<div class="pricing_pictures">
			<div class="pricing_image_left">
				<img src="/img/landings/stats-1.png" alt="">
				<p class='social_label'>Pro Statisticians</p>
				<div class="custom_hr"></div>
				<p>Our guys are well-</p> 
				<p>trained and accurate</p>
				<p class='ends'>stat-keeping machines.</p>
			</div>
			<div class="pricing_image_center">
				<img src="/img/landings/stats-2.png" alt="">
				<p class='social_label'>Detailed Stats</p>
				<div class="custom_hr"></div>
				<p>We gather detailed stats</p> 
				<p>like box scores & shot charts</p>
				<p class='ends'>for teams & players.</p>
			</div>
			<div class="pricing_image_right">
				<img src="/img/landings/stats-3.png" alt="">
				<p class='social_label'>Fully Automated</p>
				<div class="custom_hr"></div>
				<p>Stats are uploaded instantly</p> 
				<p>after every single game.</p>
				<p class='ends'>You don’t do a thing.</p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>


<div class="white_button">
	<p><a href="/packages"><button class="yellow_btn md-whiteframe-4dp">View Packages</button></a></p>
</div>

<div class="black_space">
	<div class="black_popup mvp">
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/trophy.png" alt="">
			</div>
			<div class="faq">
				<p>Get videography services and advanced stat-keeping and more with the</p>
				<p class='red'>DREAM LEAGUE PACKAGES</p>
			</div>			
		</div>

		<div class="clear"></div>
	</div>
</div>

<div id="myModal2" class="modal custom fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	    <form action="" ng-submit="submitRequest()" ng-controller="StatsController">
			<div class="header">
				<h1>Wooter Statistics</h1>
				<i class='fa fa-remove close' data-dismiss="modal"></i>
			</div>
			
			<div class="step">
				<h1>Step 1: Tell Us About Yourself</h1>
			</div>

			<div class="select_two">
				<div class="choice_line">
					<input type="text" placeholder="Full Name" ng-model='request.name' required>
				</div>

				<div class="choice_line">
					<input type="email" placeholder="Email" ng-model='request.email' required>
				</div>

				<div class="choice_line">
					<input type="numeric" mask="(999) 999-9999" placeholder="Phone Number" ng-model='request.phone' required>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address One" ng-model='request.address_1'>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address Two" ng-model='request.address_2'>
				</div>

				<div class="clear"></div>


			</div>

			<div class="step">
				<h1>Step 2: Tell Us About Your League</h1>
			</div>    

			<div class="select_three">

				<div class="choice_line">
					<input type="text" placeholder="Organization Name" ng-model='request.organization'>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Sport" ng-model='request.sport' required>
				</div>

				<div class="clear"></div>

				<div class="choice">
					<p>Number of Players</p>
					<input type="text" placeholder="0" ng-model='request.number_of_players'>
				</div>
				<div class="choice">
					<p>Number of Teams</p>
					<input type="text" placeholder="0" ng-model='request.number_of_teams'>
				</div>
				<div class="choice">
					<p>Games Per Team</p>
					<input type="text" placeholder="0" ng-model='request.number_of_games_per_team'>
				</div>
				<div class="clear"></div>
			</div>
			<div class="buttons">
				<div class="options">
					<button class='submit'>submit</button>					
					<button class='cancel close' data-dismiss="modal">cancel</button>
				</div>
			</div>
		</form>	
    </div>
  </div>
</div>

@stop

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="top: 40%;left: 50%;position: fixed;transform: translate(-50%, -45%);width: 720px;">
    <div class="modal-content">
		<iframe width="720" height="405" src="https://www.youtube.com/embed/SA2q1L35vV0" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</div>