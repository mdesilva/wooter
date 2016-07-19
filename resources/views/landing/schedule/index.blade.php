<!-- @extends('landing.layout.page') -->

@section('Main')
<div class='main' ng-controller='scheduleCtrl' ng-cloak id='popupContainer'>
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
			<md-list-item>
				<md-icon class="material-icons" >more_vert</md-icon>
				<span flex></span>
				<p class="md-subhead" flex="none">Schedule-Fall 2016</p>
				<span flex></span>
				<md-icon class="material-icons">more_vert</md-icon>
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
						<!-- 	<md-option value="test">test</md-option>
							<md-option value="test">test</md-option>
							<md-option value="test">test</md-option> -->

						</md-select>
					</md-input-container>
					<p class="separator"></p>
					<md-input-container>
						<md-select ng-model="size2" placeholder="Entire League">
							 <!-- <md-option ng-repeat='match in matches' value="week1">Week @{{ match.week }} (@{{ match.schedule[0].day | date:'MMM-dd' }} - @{{match.schedule[6].day | date:'MMM-dd' }}</md-option> -->
						</md-select>
					</md-input-container>
					<p class="separator"></p>
				</div>
				<md-button class="md-secondary md-accent new_teambtn" ng-click="createMatch($event)">NEW GAME</md-button>
				<md-button ng-click='testFunc()'>Test</md-button>
			</md-list-item>
			<md-list-item style="justify-content: center;font-weight:500;background-color: rgb(245, 245, 245); color: rgba(1, 1, 1, 0.541);text-transform: uppercase;">
			Full Schedule
			</md-list-item>
		</md-list>
	</md-content>

	<div ng-repeat='match in matches' class='schedules_list' style='max-width: 1280px; left: 0; right: 0; margin: auto; margin-top: 15px'>
	    <md-list>

			<p class="matchdate" style="font-weight: 400;padding-left: 16px">Week @{{ match.week }} (@{{ match.schedule[0].day | date:'MMM dd' }} - @{{match.schedule[6].day | date:'MMM dd' }} )</p>

			<div class='md-whiteframe-2dp' ng-repeat='schedule in match.schedule'>

				<md-list-item style="justify-content: center;background-color: rgb(245, 245, 245); color: rgba(1, 1, 1, 0.541);">
				@{{ schedule.day | date:'MMMM dd,yyyy' }}
				</md-list-item>
				<md-divider></md-divider>
				<md-list-item ng-repeat='matchup in schedule.slots' style='background-color: white'>
					<md-checkbox></md-checkbox>
						<p class='date' style="color: rgba(0, 0, 0, 0.541);">
							@{{ matchup.time.time | date:'shortTime'}}
						</p>

						<img ng-src='@{{ matchup.teams[0].img }}' style='height: 24px; width: 24px;margin-right: 16px'>


						<p style='color: rgba(0, 0, 0, 0.871);'>
							@{{ matchup.teams[0].id }}: @{{ matchup.teams[0].name }}
						</p>

						<p style='text-align: center;'>
							<span>vs.</span>
						</p>


						<p style='text-align: end; color: rgba(0, 0, 0, 0.871)'>
							@{{ matchup.teams[1].id }}: @{{ matchup.teams[1].name }}
						</p>


						<img ng-src='@{{ matchup.teams[1].img }}' style='width: 24px; height: 24px;margin-left: 16px'>


						<p style="padding-left: 80px;color: rgba(0, 0, 0, 0.541);">
							<span class='location'>
								@{{ matchup.court.name }}
							</span>
						</p>

					<md-icon class='material_icons md-secondary' ng-click='editMatch($event)'>
						mode_edit
					</md-icon>
					<md-divider></md-divider>
				</md-list-item>
			</div>
		</md-list>
	</div>
</div>
@stop