@extends('landing.layout.page')
@include('templates.ui.notify-container')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<h1>Wooter Referees</h1>
		<p>Hiring referees for your league is easy and affordable.</p>
		<p>Reach out to get a quote today!</p>
		<a href="#"><button class="yellow_btn md-whiteframe-4dp" data-toggle="modal" data-target="#myModal2">Get A Quote</button></a>
	</div>
</div>

<div class="black_space">
	<div class="black_popup commissioners">
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/medals.png" alt="">
			</div>
			<div class="faq">
				<p>Certified</p>
			</div>			
		</div>
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/hearts.png" alt="">
			</div>
			<div class="faq">
				<p>Reliable</p>
			</div>			
		</div>
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/moneybags.png" alt="">
			</div>
			<div class="faq">
				<p>Affordable</p>
			</div>			
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="white_space space_one">
	<div class="white_popup md-whiteframe-4dp strategy popup_one">
		<div class="pricing_text">
			<h1>Any Sport Any Time</h1>
			<p>We have highly trained refs for</p>
   			<p>dozens of different sports.</p>
			<div class='custom_hr'></div>		
		</div>

		<div class='sports_list'>
			<p>Basketball</p>
			<p>Volleyball</p>
			<p>Boxing</p>
			<p>Football</p>
			<p>Baseball</p>
			<p>Tennis</p>
			<p>Soccer</p>
			<p>Softball</p>
			<p>...& more!</p>
			<div class="clear"></div>
		</div>

		<div class="pricing_subtext">
			<div class='custom_hr'></div>
			<p>Just click “Get A Quote”  and take a minute to fill out the form. <br>
			We will contact you shortly after to walk you through everything.</p>
		</div>
	</div>
</div>

<div class="white_button">
	<p><a href="#"><button class='yellow_btn md-whiteframe-4dp' data-toggle="modal" data-target="#myModal2">Get A Quote</button></a></p>
</div>

<div id="myModal2" class="modal custom fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	    <form ng-submit="submitRequest($event)" ng-controller="RefreesController">
			<div class="header">
				<h1>Wooter Referees</h1>
				<i class='fa fa-remove close' data-dismiss="modal"></i>
			</div>
			
			<div class="step">
				<h1>Step 1: Tell Us About Yourself</h1>
			</div>

			<div class="select_two">
				<div class="choice_line">
					<input type="text" placeholder="Full Name" ng-model='refree.name' required>
				</div>

				<div class="choice_line">
					<input type="email" placeholder="Email" ng-model='refree.email' required>
				</div>

				<div class="choice_line">
					<input type="numeric" mask="(999) 999-9999" placeholder="Phone Number" ng-model='refree.phone' required>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address One" ng-model='refree.address_1' required>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address Two" ng-model='refree.address_2' required>
				</div>

				<div class="clear"></div>


			</div>

			<div class="step">
				<h1>Step 2: Tell Us About Your League</h1>
			</div>    

			<div class="select_three">

				<div class="choice_line">
					<input type="text" placeholder="Organization Name" ng-model='refree.organization'>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Sport" ng-model='refree.sport' required>
				</div>

				<div class="clear"></div>

				<div class="choice">
					<p>Number of Players</p>
					<input type="text" placeholder="0" ng-model='refree.number_of_players' required>
				</div>
				<div class="choice">
					<p>Number of Teams</p>
					<input type="text" placeholder="0" ng-model='refree.number_of_teams' required>
				</div>
				<div class="choice">
					<p>Games Per Team</p>
					<input type="text" placeholder="0" ng-model='refree.number_of_games_per_team' required>
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