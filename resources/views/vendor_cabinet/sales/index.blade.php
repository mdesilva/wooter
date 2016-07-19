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
    <md-tabs md-border-bottom>
      <md-tab label="Registration Log">
        <md-content>          
			
			<div class="sales_innards container md-whiteframe-4dp">
				<div class="pages_ndots">
					<div class="pages"><p>Payees</p></div>
					<div class="dots"><p>:</p></div>
					<div class="clear"></div>
				</div>
				<div class="pages_search">
					<div class="player_drops">
						<p class='toggle_dropdown'>Players &nbsp;&nbsp;&nbsp; <i class="fa fa-caret-down"></i></p>
						<div class="player_menu md-whiteframe-2dp hide">
							<ul>
								<a href="#"><li>Reasons 1</li></a>
								<a href="#"><li>Reasons 2</li></a>
								<a href="#"><li>Reasons 3</li></a>
								<a href="#"><li>Reasons 4</li></a>
							</ul>
						</div>
					</div>
					<div class="player_search">
						<p><i class="fa fa-search"></i></p>
						<input type="text" placeholder="Search for team or player:">
					</div>
				</div>
				<div class="player_results">
					<table>
						<tbody>
							<tr class='table_header'>
								<th class='icons_checks'><input type="checkbox"></th>
								<th class='icons_checks'><!-- avatar --></th>
								<th>Player</th>
								<th>Team</th>
								<th>Payment Status</th>
								<th>Phone</th>
								<th class='icons_checks'><!-- avatar --></th>
							</tr>
							<tr class='table_lists md-whiteframe-2dp'>
								<td class='icons_checks'><input type="checkbox"></td>
								<td class='icons_checks'><img src="" alt="player_avatar"></td>
								<td>player</td>
								<td>team</td>
								<td>payment status</td>
								<td>phone</td>
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

