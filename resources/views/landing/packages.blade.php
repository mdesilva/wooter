@extends('landing.layout.page')
@include('templates.ui.notify-container')
@section('Main')

<div class="hero_image">
	<div class="hero_text">
		<h1>Wooter Packages</h1>
		<p>This is the final page</p>
		<p>on your quest for a better league. </p>
		<p>Take the “W”, today.</p>
	</div>
</div>

<div class="white_separator_origin space_one">
	<div class="white_separator_3 popup_one">
		<div class="running_image">
			<img src="/img/landings/package-kicks.png" alt="">
		</div>		

		<div class="white_separator_left md-whiteframe-4dp">
			<div class="ws">
				<div class="social_image">
					<img src="/img/landings/package-free.png" alt="">
				</div>
				<p class='social_label'><span class='red'>PRO</span> Package</p>
				<div class='custom_hr'></div>
				<ul>
					<li>Management Software</li>
					<li>Marketplace Listing</li>
					<li>Access to Wooter Platform</li>
				</ul>
				<div class='custom_hr'></div>
				<button class='yellow_btn md-whiteframe-4dp' ng-click='package("pro")'>Select Pro Package</button>
			</div>
			<div class="clear"></div>
		</div>

		<div class="white_separator_center md-whiteframe-4dp">
			<div class="ws">			
				<p class='social_label'><span class='red'>ELITE</span> Package</p>
				<div class='custom_hr'></div>
				<ul>
					<li>Management Software</li>
					<li>Marketplace Listing</li>
					<li>Access to Wooter Platform</li>
					<li><strong>Full Game Footage</strong></li>
					<li><strong>Statistics Keeping</strong></li>
					<li><strong>League Hub Membership</strong></li>
				</ul>
				<div class='custom_hr'></div>
				<button class='yellow_btn md-whiteframe-4dp' ng-click='package("elite")'>Select Elite Package</button>		
			</div>
			<div class="clear"></div>
		</div>

		<div class="white_separator_right md-whiteframe-4dp">
			<div class="ws">
				<div class="social_image">
					<img src="/img/landings/package-best.png" alt="" style="width: 60px;">
				</div>				
				<p class='social_label'><span class='red'>LEGEND</span> Package</p>
				<div class='custom_hr'></div>
				<ul>
					<li>Management Software</li>
					<li>Marketplace Listing</li>
					<li>Access to Wooter Platform</li>
					<li>Full Game Footage</li>
					<li>Statistics Keeping</li>
					<li>League Hub Membership</li>
					<li><strong>Social Media Management</strong></li>
					<li><strong>Game Highlights</strong></li>
					<li><strong>Media Coverage</strong></li>
				</ul>
				<div class='custom_hr'></div>
				<button class='yellow_btn md-whiteframe-4dp' ng-click='package("legend")'>Select Legend Package</button>		
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<div class="black_space">
	<div class="black_popup commissioners">
		<div class="red_pics">
			<div class="image">
				<img src="/img/landings/package-cog.png" alt="">
			</div>
			<div class="faq">
				<p>You can customize your package</p>
				<p>with the features listed below.</p>
			</div>			
		</div>

		<div class="clear"></div>
	</div>
</div>

<div class="white_space space_two">
	<div class="white_popup md-whiteframe-4dp strategy popup_two">
		<div class="pricing_text">
			<div class="feature_header">
				<h1>The Essentials</h1>
				<p><i>(included with Elite and Legend Packages)</i></p>
				<div class="short_hr"></div>
				<div class="clear"></div>
			</div>
			<div class="split_one">
				<div class="thirds">
					<h1>Full Game Footage</h1>
					<p>Recorded with a 1080p HD camera in broadcast view.</p>
				</div>
				<div class="thirds">
					<h1>Game Highlights</h1>
					<p>We’ll create an ESPN-like 2-3 min highlight for each game.</p>
				</div>
				<div class="thirds">
					<h1>Stats</h1>
					<p>A personal statistician will record advanced stats for your league. </p>
				</div>
				<div class="clear"></div>
			</div>
			<div class="custom_hr"></div>
			<div class="baseball_split">
				<div class="picture">
					<img src="/img/landings/package-baseball.png" alt="">					
				</div>
				<div class="media_coverage">
					<div class="mc_title">
						<h1>Media Coverage</h1>
						<div class="short_hr"></div>
						<div class="clear"></div>						
					</div>
					<div class="mc_text">
						<div class="halves">
							<h1>Top 10 Plays</h1>
							<p>The 10 best plays of the week, month or season</p>
						</div>
						<div class="halves">
							<h1>Professional Videography</h1>
							<p>An experienced videographer records the action from close up.</p>
						</div>
						<div class="halves">
							<h1>Team Photos</h1>
							<p>Photos of every team in your league</p>
						</div>
						<div class="halves">
							<h1>Weekly Recap</h1>
							<p>A custom article summarizing the full week of action.</p>
						</div>
						<div class="halves">
							<h1>Player Photos</h1>
							<p>Photos of every player in your league</p>
						</div>							
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<div class="custom_hr"></div>
			<div class="clear"></div>
			<div class="football_split">
				<div class="marketing">
					<div class="market_title">
						<h1>Marketing</h1>
						<div class="short_hr"></div>
						<div class="clear"></div>						
					</div>
					<div class="market_text">
						<div class="thirds">
							<h1>Full Game Footage</h1>
							<p>Recorded with a 1080p HD camera in broadcast view.</p>
						</div>
						<div class="thirds">
							<h1>Game Highlights</h1>
							<p>We’ll create an ESPN-like 2-3 min highlight for each game.</p>
						</div>
						<div class="thirds">
							<h1>Stats</h1>
							<p>A personal statistician will record advanced stats for your league. </p>
						</div>	
						<div class="clear"></div>					
					</div>

				</div>
				<div class="separators">
					<div class="line"></div>
				</div>			
				<div class="highlight">
					<div class="text">
						<h1>Player/Team Highlights</h1>
						<p><i>(Available upon request)</i></p>
						<div class="short_hr"></div>
						<div class="clear"></div>
						<p class='normal'>Players can request a highlight video to show off on social media or to send to scouts. Perfect for a recreational player or an aspiring pro. </p>	
					</div>
					<div class="picture">
						<img src="/img/landings/package-football.png" alt="">					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="black_space">
	<div class="black_popup package">
		<div class="red_pics">
			<div class="faq">
				<p>Can't decide on a package?</p>
				<br>
				<br>
				<button data-toggle="modal" data-target="#customModal" class='yellow_btn md-whiteframe-4dp'>Create Custom Package</button>
			</div>			
		</div>

		<div class="clear"></div>
	</div>
</div>

<div id="customModal" class="modal custom fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	    <form ng-submit="submitCustomPackage()" ng-controller="PackageController">
			<div class="header">
				<h1>Wooter Packages</h1>
				<i class='fa fa-remove close' data-dismiss="modal"></i>
			</div>
			
			<div class="step">
				<h1>Step 1: Select A Base Package</h1>
			</div>

			<div class="select_one">
				<div class="choice">
					<md-checkbox ng-click="customPackagePro(custom_pro)" ng-model="custom_pro">Pro Package</md-checkbox>	
				</div>
				<div class="choice" style='border-left: 1px solid #eee; border-right: 1px solid #eee;'>
					<md-checkbox ng-click="customPackageElite(custom_elite)" ng-model="custom_elite">Elite Package</md-checkbox>	
				</div>
				<div class="choice">
					<md-checkbox ng-click="customPackageLegend(custom_legend)" ng-model="custom_legend">Legend Package</md-checkbox>	
				</div>
				<div class="clear"></div>
			</div>

			<div class="step">
				<h1>Step 2: Customize Your Package With Add-On Features (optional)</h1>
			</div>

			<div class="select_two">
				<div class="table_choice">
					<div class="table_header">
						<h1>Software (FREE)</h1>
					</div>
					<md-checkbox ng-disabled="true" aria-label="Disabled checked checkbox" ng-init="data.cb4=true">League Mgmt. Software</md-checkbox>
					<br>
					<md-checkbox ng-disabled="true" aria-label="Disabled checked checkbox" ng-init="data.cb4=true">Marketplace Listing</md-checkbox>
					<br>
					<md-checkbox ng-disabled="true" aria-label="Disabled checked checkbox" ng-init="data.cb4=true">Wooter Platform Access</md-checkbox>
					<br>
					<md-checkbox style='visibility: hidden;'>Player Photos</md-checkbox>
					<br>
					<md-checkbox style='visibility: hidden;'>Team Photos</md-checkbox>		

				</div>
				<div class="table_choice">
					<div class="table_header">
						<h1>Essentials</h1>
					</div>
					<md-checkbox ng-model="custom.full_game_footage">Full Game Footage</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.game_highlights">Game Highlights</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.statistics">Statistics</md-checkbox>
					<br>
					<md-checkbox style='visibility: hidden;'>Player Photos</md-checkbox>
					<br>
					<md-checkbox style='visibility: hidden;'>Team Photos</md-checkbox>	
				</div>
				<div class="table_choice">
					<div class="table_header">
						<h1>Media Coverage</h1>
					</div>
					<md-checkbox ng-model="custom.pro_videography">Pro Videography</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.top_10">Top 10</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.weekly_recap">Weekly Recap</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.player_photos">Player Photos</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.team_photos">Team Photos</md-checkbox>				
				</div>
				<div class="table_choice">
					<div class="table_header">
						<h1>Marketing</h1>
					</div>
					<md-checkbox ng-model="custom.promo_video">Promo Video</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.media_coverage">Media Coverage</md-checkbox>
					<br>
					<md-checkbox ng-model="custom.blog_exposure">Blog Exposure</md-checkbox>
					<br>
					<md-checkbox style='visibility: hidden;'>Player Photos</md-checkbox>
					<br>
					<md-checkbox style='visibility: hidden;'>Team Photos</md-checkbox>	
				</div>
				<div class="clear"></div>
			</div>

			<div class="step">
				<h1>Step 3: Tell Us About Yourself</h1>
			</div>

			<div class="select_two">
				<div class="choice_line">
					<input type="text" placeholder="Full Name" ng-model='custom.name' required>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Email" ng-model='custom.email' required>
				</div>

				<div class="choice_line">
					<input type="numeric" mask="(999) 999-9999" placeholder="Phone Number" ng-model='custom.phone' required>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address One" ng-model='custom.address1'>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address Two" ng-model='custom.address2'>
				</div>

				<div class="clear"></div>


			</div>

			<div class="step">
				<h1>Step 4: Tell Us About Your League</h1>
			</div>    

			<div class="select_three">

				<div class="choice_line">
					<input type="text" placeholder="Organization Name" ng-model='custom.organization'>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Sport" ng-model='custom.sport' required>
				</div>

				<div class="clear"></div>

				<div class="choice">
					<p>Number of Players</p>
					<input type="text" placeholder="0" ng-model='custom.number_of_players' required>
				</div>
				<div class="choice">
					<p>Number of Teams</p>
					<input type="text" placeholder="0" ng-model='custom.number_of_teams' required>
				</div>
				<div class="choice">
					<p>Games Per Team</p>
					<input type="text" placeholder="0" ng-model='custom.number_of_games_per_team' required>
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


<div id="packageModal" class="modal custom fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	    <form ng-submit="submitPackage()" ng-controller="PackageController">
			<div class="header">
				<h1>Package Inquiry</h1>
				<i class='fa fa-remove close' data-dismiss="modal"></i>
			</div>
			
			<div class="step">
				<h1>Step 1: Choose A Package</h1>
			</div>

			<div class="select_one">
				<div class="choice">
					<md-checkbox ng-disabled="true" aria-label="Disabled checked checkbox" name="package_type" ng-model="package_pro" value="pro">Pro Package</md-checkbox>	
				</div>
				<div class="choice" style='border-left: 1px solid #eee; border-right: 1px solid #eee;'>
					<md-checkbox ng-disabled="true" aria-label="Disabled checked checkbox" name="package_type" ng-model="package_elite" value="elite" >Elite Package</md-checkbox>	
				</div>
				<div class="choice">
					<md-checkbox ng-disabled="true" aria-label="Disabled checked checkbox" name="package_type" ng-model="package_legend" value="legend">Legend Package</md-checkbox>	
				</div>
				<div class="clear"></div>
			</div>

			<div class="step">
				<h1>Step 2: Tell Us About Yourself</h1>
			</div>

			<div class="select_two">
				<div class="choice_line">
					<input type="text" placeholder="Full Name" ng-model='name' name="name" required>
				</div>

				<div class="choice_line">
					<input type="email" placeholder="Email" ng-model='email' name="email" required>
				</div>

				<div class="choice_line">
					<input type="numeric" mask="(999) 999-9999" placeholder="Phone Number" ng-model='phone' name="phone" required>
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address One" ng-model='address1' name="address1">
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Address Two" ng-model='address2' name="address2">
				</div>

				<div class="clear"></div>


			</div>

			<div class="step">
				<h1>Step 3: Tell Us About Your League</h1>
			</div>    

			<div class="select_three">

				<div class="choice_line">
					<input type="text" placeholder="Organization Name" ng-model='organization' name="organization">
				</div>

				<div class="choice_line">
					<input type="text" placeholder="Sport" ng-model='sport' name="sport" required>
				</div>

				<div class="clear"></div>

				<div class="choice">
					<p>Number of Players</p>
					<input type="number" placeholder="0" ng-model='players' name="players" required>
				</div>
				<div class="choice">
					<p>Number of Teams</p>
					<input type="number" placeholder="0" ng-model='teams' name="teams" required>
				</div>
				<div class="choice">
					<p>Games Per Team</p>
					<input type="number" placeholder="0" ng-model='games_teams' name="games_teams" required>
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