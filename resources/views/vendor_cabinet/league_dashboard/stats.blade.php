<!-- @extends('landing.layout.page') -->

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
	<md-content class="schedule_content" ng-init='genSchedule()'>
		<md-list class="md-whiteframe-2dp">
			<md-list-item style='background-color: rgb(245, 245, 245);'>
				<p class="md-subhead" flex="none" style="text-align: center;">Stats & Scores</p>
			</md-list-item>
			<md-divider></md-divider>
			<md-list-item>
				<div flex="50" layout="row" layout-align="space-between center">
					<md-input-container>
						<md-select ng-model="size" placeholder="Entire League">
							<!-- <md-option value="test">test</md-option>
							<md-option value="test">test</md-option>
							<md-option value="test">test</md-option> -->
						</md-select>
					</md-input-container>
					<p class="separator"></p>
					<md-input-container>
						<md-select ng-model="size1" placeholder="Entire League">
						<!-- <md-option value="test">test</md-option>
							<md-option value="test">test</md-option>
							<md-option value="test">test</md-option> -->
						</md-select>
					</md-input-container>
					<p class="separator"></p>
					<md-input-container>
						<md-select ng-model="size2" placeholder="Entire League">
							<!-- <md-option value="test">test</md-option>
							<md-option value="test">test</md-option>
							<md-option value="test">test</md-option> -->
						</md-select>
					</md-input-container>
					<p class="separator"></p>
				</div>
				<md-button class="md-secondary md-accent new_teambtn" ng-click="">New Team</md-button>
			</md-list-item>
			<md-list-item style="justify-content: center;background-color: rgb(245, 245, 245); color: rgba(1, 1, 1, 0.541);text-transform: uppercase;">
			Full Schedule
			</md-list-item>
		</md-list>
	</md-content>

	<div ng-repeat='match in matches' class'schedules_list' style='max-width: 1280px; left: 0; right: 0; margin: auto; margin-top: 15px'>
	    <md-list>
			Week @{{ match.week }}

			<div class='md-whiteframe-2dp' ng-repeat='schedule in match.schedule'>


				<md-list-item style="justify-content: center;background-color: rgb(245, 245, 245); color: rgba(1, 1, 1, 0.541);">
					@{{ schedule.day |  date:'MMMM d, yyyy'}}
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item ng-repeat='matchup in schedule.slots' style='background-color: white'>
						<p class='date' style="color: rgba(0, 0, 0, 0.541);">
							{{--@{{ matchup.time.time }}--}}
							5:00 A M
						</p>

						<img ng-src='@{{ matchup.teams[0].img}}' style='height: 24px; width: 24px;margin-right: 16px'>


						<p style='color: rgba(0, 0, 0, 0.871);'>
							@{{ matchup.teams[0].id }}: @{{ matchup.teams[0].name }}
						</p>

						<p style='text-align: center;'>
							<span>vs.</span>
						</p>


						<p style='text-align: end; color: rgba(0, 0, 0, 0.871)'>
							@{{ matchup.teams[1].name }}: @{{ matchup.teams[1].id }}
						</p>


						<img ng-src='@{{ matchup.teams[1].img }}' style='width: 24px; height: 24px;margin-left: 16px'>


						<p style="padding-left: 80px;color: rgba(0, 0, 0, 0.541);">
							<span class='location'>
								@{{ matchup.court.name }}
							</span>
						</p>

					<md-icon class='material_icons md-secondary' ng-click=''>
						mode_edit
					</md-icon>
					<md-divider></md-divider>
				</md-list-item>
			</div>
		</md-list>
	</div>
</div>
@include('vendor_cabinet.league_dashboard.JavaScript_Links')

@stop