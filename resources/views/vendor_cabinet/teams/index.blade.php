@extends('landing.layout.page')

@section('Main')

<header id="dashboardHeader" class="">
    <div class="container">
        <div class="info">
            <h1 class="md-title league-title">Example Name</h1>
            <p class="md-body-1 league-subtitle">Registrations</p>
        </div>
        <div class="nav-bar" ng-include="logicTemplate('dashboard/layout/nav-bar')"></div>
    </div>
</header>

<div ng-cloak class='sales_dashboard'>
  <md-content>
    <md-tabs  md-dynamic-height md-border-bottom>
      <md-tab label="Teams">
        <md-content style='min-height: 80vh'>          
			<div class="sales_innards container md-whiteframe-4dp" ng-controller='scheduleCtrl'>
				<div class="pages_ndots">
					<div class="pages"><p>Teams</p></div>
				</div>
				<div class="pages_search">
					<div class="player_drops">
						<p class='toggle_dropdown'>Entire League &nbsp;&nbsp;&nbsp; <i class="fa fa-caret-down"></i></p>
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
					<div class="player_drops">
						<p class='toggle_dropdown'><i class="fa fa-caret-down"></i> ADD TEAM</p>
					</div>
				</div>
				<div class="player_results" >
					<table>
						<tbody>
							<tr class='table_header'>
								<th class='icons_checks'><md-checkbox ng-model="data.cb2"></md-checkbox></th>
								<th class='icons_checks'><!-- avatar --></th>
								<th class='team_name'> </th>
								<th>W</th>
								<th>L</th>
								<th>T</th>
								<th>Pct.</th>
								<th class='icons_checks'><!-- avatar --></th>
							</tr>
							<tr class='table_lists md-whiteframe-2dp' ng-repeat="team in teams | orderBy:'-wins' |filter:{name: search.name}">
								<td class='icons_checks'><md-checkbox ng-model="data.cb3"></md-checkbox></td>
								<td class='icons_checks'><img src="@{{ team.img }}" alt="player_avatar"></td>
								<td class='team_name'>@{{ team.name }}</td>
								<td>@{{ team.wins }}</td>
								<td>@{{ team.loss }}</td>
								<td>@{{ team.ties }}</td>
								<td>0</td>
								<td class='icons_checks'><img src="" alt="email_icon"></td>						
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </md-content>
      </md-tab>
    </md-tabs>
  </md-content>
</div>



<script>
	
$( document ).ready(function() {
	$('md-tabs-canvas').addClass('container');
	$('.toggle_dropdown').click(function(){
		$( '.player_menu' ).toggleClass('hide');
	});

});

</script>


@stop

