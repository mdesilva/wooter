@extends('landing.layout.page')

@section('Main')

<div class='main' ng-controller='scheduleCtrl' ng-cloak>
	<div class="md-whiteframe-2dp">
	<!-- Main Page stuff -->
		<div layout='column' layout-align="start center"  class="hero_header">
			<!-- Dummy Stuff for now -->
			<div layout='column' class='leagueHead' layout-align="start start">
				<h3 class="">Dream Leagues Elite 8.5</h3>
				<p>Fall 2016</p>
			</div>
		</div>
		<div layout="row" ng-controller="tabsCtrl" class="main_tabs" style="background-color: #024F7E;" layout-align="center center">
			<md-tabs flex class="vendor_tabs" md-no-pagination="false" md-stretch-tabs="never">
				<md-tab ng-repeat="tab in tabs" label="@{{tab.name}}"></md-tab>
			</md-tabs>
		</div>
	</div>
   	<div style='min-height: 100vh'> 
		<div class="sales_innards container md-whiteframe-4dp" ng-controller='scheduleCtrl'>
			<div class="pages_team">
				<img src="/img/landing/schedule/devils.png" alt="">
				<div class="credentials">
					<h4><b>Wooter</b></h4>
					<p>Division 1 | 35-17</p>					
				</div>			
				<div class="buttons">
					<img src="../../img/dashboard/message.png" alt="email_icon">
					<img src="../../img/dashboard/garbage.png" alt="email_icon">
				</div>

			</div>


			<div class="pages_players">
				<div class="pages"><h4>Players</h4></div>
				<div class="pages_add"><h4>Add Player(s)</h4></div>
			</div>

			<div class="player_results" >
				<table>
					<tbody>
						<tr class='table_lists md-whiteframe-2dp' 
							ng-repeat="player in players | orderBy:'lName'">

							<td class='icons_checks'><md-checkbox ng-model="data.cb3"></md-checkbox></td>
							<td class='icons_checks'><img src="@{{player.pictureLink}}" alt="player_avatar"></td>
							<td class='team_name'>@{{player.lName}}, @{{player.fName}}</td>
		
							<td class='team_phone'>@{{ player.phone }}</td>

							<td class='icons_checks email_message'><img src="../../img/dashboard/message.png" alt="email_icon"></td>						
						</tr>
					</tbody>
				</table>
			</div>


			<div class="pages_players">
				<div class="pages"><h4>Photos</h4></div>
				<div class="pages_add"><h4>Add Photo(s)</h4></div>
			</div>
	
			<div class="slider">
				
				<div class="back">
					<img src="../../img/dashboard/left_arrow.png" alt="">
				</div>

				<div class="photos">
					<div class="limit">
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>					
					</div>
				</div>

				<div class="forth">
					<img src="../../img/dashboard/right_arrow.png" alt="">
				</div>
			</div>

			<div class="pages_players">
				<div class="pages"><h4>Videos</h4></div>
				<div class="pages_add"><h4>Add Video(s)</h4></div>
			</div>


			<div class="slider">
				
				<div class="back">
					<img src="../../img/dashboard/left_arrow.png" alt="">
				</div>

				<div class="photos">
					<div class="limit">
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
						<div class="images">
							
						</div>
					</div>
				</div>

				<div class="forth">
					<img src="../../img/dashboard/right_arrow.png" alt="">
				</div>
			</div>



		</div>
	</div>   
</div>
@include('vendor_cabinet.league_dashboard.JavaScript_Links')
<script>
$( document ).ready(function() {
	$('md-tabs-canvas').addClass('container');
	$('.toggle_dropdown').click(function(){
		$( '.player_menu' ).toggleClass('hide');
	});

	$('.back').click(function () {
	    var leftPos = $('.photos').scrollLeft();
	    console.log(leftPos);
	    $(".photos").animate({
	        scrollLeft: leftPos - 340
	    }, 800);
	});

	$('.forth').click(function () {
	    var leftPos = $('photos').scrollLeft();
	    console.log(leftPos);
	    $(".photos").animate({
	        scrollLeft: leftPos + 340
	    }, 800);
	});

});
</script>

@stop