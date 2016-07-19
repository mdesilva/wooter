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
			<div class="pages_ndots">
				<div class="pages"><p>Photos</p></div>
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
				<div class="player_drops">
					<p class='toggle_dropdown'>Week 1 (Feb 1- Feb 8) &nbsp;&nbsp;&nbsp; <i class="fa fa-caret-down"></i></p>
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
					
				</div>
				<div class="player_add">
					
				<p class="md-secondary md-accent new_teambtn red" ng-click="createPhoto($event)"><i class="fa fa-plus"></i>&nbsp; ADD Photos</md-button>
				</p>

				</div>
			</div>
			<div class="player_results" >
				<div class="photos">
					<div class="limit">
						<div class="images">
							<img class='results' src="" alt="">
							<div class="hovering">
								<p class='title'>TITLE</i></p>
								<p class='delete'>X</i></p>
								<p class='edit'>EDIT</i></p>										
							</div>
						</div>
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
						<div class="images">
							
						</div>	
					</div>
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

    $(":file").css("background-color", "red");


});
</script>

@stop