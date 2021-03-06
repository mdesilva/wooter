@extends('landing.layout.page')

@section('Main')

<div class='main' ng-controller='scheduleCtrl' ng-cloak>
	
	<div class="md-whiteframe-2dp">
	<!-- Main Page stuff -->
	
		<div layout='column' layout-align="start center"  class="hero_header">
			<!-- Dummy Stuff for now -->
	
			<div layout='column' class='leagueHead' layout-align="start start">
				<h3>Dream Leagues Elite 8.5</h3>
				<p>Fall 2016</p>
			</div>
		</div>
		<div layout="row" 
			 ng-controller="tabsCtrl" 
			 class="main_tabs" 
			 style="background-color: #024F7E;" 
			 layout-align="center center">
			
			<md-tabs flex 
					 class="vendor_tabs" 
					 md-no-pagination="false" 
					 md-stretch-tabs="never">
				
				<md-tab ng-repeat="tab in tabs" label="@{{tab.name}}"></md-tab>
			</md-tabs>
		</div>
	</div>

   	<div style='min-height: 100vh'> 
		<div class="sales_innards container md-whiteframe-4dp" ng-controller='scheduleCtrl'>
			
			<div class="pages_ndots">
				<div class="pages"><p>Players</p></div>
			</div>
			
			<div class="pages_search">
				<div class="player_drops">
					<p class='toggle_dropdown'>
						Entire League &nbsp;&nbsp;&nbsp; 
						<i class="fa fa-caret-down"></i>
					</p>
					
					<div class="player_menu md-whiteframe-2dp hide">
						<ul>
							<a href="#"><li>Division 1</li></a>
							<a href="#"><li>Division 2</li></a>
							<a href="#"><li>Division 3</li></a>
							<a href="#"><li>Division 4</li></a>
						</ul>
					</div>	
				</div>
				
				<div class="player_search">
					<p><i class="fa fa-search"></i></p>
					<input type="text" placeholder="Search For A Team:" ng-model="searchPlayer">
				</div>

				<div class="player_add">
					<p class="md-secondary md-accent new_teambtn red" ng-click="createPlayer($event)">
						<img style='width: 20px;' src="../img/dashboard/group_icon.png"/>
						&nbsp; ADD PLAYER
					</p>
				</div>
			</div>
			<div class="player_results" >
				<table>
					<tbody>
						<tr class='table_header'>
							<th class='icons_checks'>
								<md-checkbox ng-model="data.cb2"></md-checkbox>
							</th>
							<th class='icons_checks'><!-- avatar --></th>
							<th class='team_name'> </th>
							<th>Team</th>
							<th>Phone</th>
							<th class='icons_checks'><!-- avatar --></th>
						</tr>
						<tr class='table_lists md-whiteframe-2dp' 
							ng-repeat="player in players | filter: searchPlayer">
							<td class='icons_checks'>
								<md-checkbox ng-model="data.cb3"></md-checkbox>
							</td>
							<td class='icons_checks'>
								<img src="@{{player.pictureLink}}" alt="player_avatar">
							</td>
							<td class='team_name'>@{{player.fName}} @{{player.lName}}</td>
							<td>@{{ player.team }}</td>
							<td>@{{ player.phone }}</td>

							<td class='icons_checks email_message'><img src="../img/dashboard/message.png" alt="email_icon"></td>						
						</tr>
					</tbody>
				</table>
			</div>
			<div class="clear"></div>
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
});
</script>

@stop