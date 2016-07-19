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

			<md-tabs flex class="vendor_tabs" 
					 md-no-pagination="false" 
					 md-stretch-tabs="never">

				<md-tab ng-repeat="tab in tabs" label="@{{tab.name}}"></md-tab>

			</md-tabs>
		</div>
	</div>

   	<div style='min-height: 100vh'> 
		<div class="sales_innards container md-whiteframe-4dp" ng-controller='scheduleCtrl'>
			
			<div class="pages_ndots">
				<div class="pages"><p>Teams</p></div>
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
					<input type="text" placeholder="Search For A Team:" ng-model="search.name">
				</div>
				
				<div class="player_add">
					<p class="md-secondary md-accent new_teambtn red" ng-click="createTeam($event)">
						<img style='width: 20px;' src="../img/dashboard/group_icon.png"/>
						&nbsp; ADD TEAM
					</p>
				</div>
			</div>

			<div class="player_results" >
				<table>
					<tbody>
						<tr class='table_header'>
							<th class='icons_checks'>
								<md-checkbox aria-label="master" 
											 name="team_action" 
											 onClick="toggle(this)" 
											 id="checkbox_all"></md-checkbox>
							</th>
							<th class='icons_checks'><!-- avatar --></th>
							<th class='team_name'> </th>
							<th>W</th>
							<th>L</th>
							<th>T</th>
							<th>Pct.</th>
							<th class='icons_checks'><!-- avatar --></th>
						</tr>
						<tr class='table_lists md-whiteframe-2dp' 
							ng-repeat="team in teams | orderBy:'-wins' |filter:{name: search.name}">

							<td class='icons_checks'>
								<md-checkbox aria-label="team_check" 
											 name="team_action" 
											 id="checkbox@{{team.id}}"></md-checkbox>
							</td>
							<td class='icons_checks'>
								<a href="/leaguedash/teams/info">
									<img src="@{{ team.img }}" alt="player_avatar">
								</a>
							</td>
							<td class='team_name'>
								<a class='t_name' href="/leaguedash/teams/info">
									@{{ team.name }}
								</a>
							</td>
							<td>@{{ team.wins }}</td>
							<td>@{{ team.loss }}</td>
							<td>@{{ team.ties }}</td>
							<td>0</td>
							<td class='icons_checks email_message'>
								<img src="../img/dashboard/message.png" alt="email_icon">
							</td>						
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div> 
</div>

	<div class="bottom_popup md-whiteframe-4dp">
		<div class="centered">
				<div class="bottom_selection">
						<p class='num_checked' style='color: rgba(0,0,0,.34)'>(0) Team(s) Selected</p>
				</div>    
				<div class="bottom_action">
					<div class="bottom_center mess">
						<img style='width: 20px; margin: 20px 10px 0px;' src="../img/dashboard/red_message.png" alt="">
						<p style='color: #ed514f'>MESSAGE</p>
					</div>
				</div>
				<div class="bottom_action">
					<div class="bottom_center move">
						<img style='width: 20px; margin: 20px 10px 0px;' src="../img/dashboard/move.png" alt="">
						<p style='color: #ed514f'>MOVE</p>
					</div>
				</div>
				<div class="bottom_action">
					<div class="bottom_center del">
						<img style='width: 15px; margin: 19px 10px 0px;' src="../img/dashboard/garbage.png" alt="">
						<p style='color: rgba(0,0,0,.34)'>DELETE</p>
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


	var n = $("input:checkbox:checked").length;
	$( ".num_checked" ).text( "(" + n + ") Team(s) Selected" );		

});

function toggle(source) {
  checkboxes = document.getElementsByName('team_action');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}




</script>

@stop

