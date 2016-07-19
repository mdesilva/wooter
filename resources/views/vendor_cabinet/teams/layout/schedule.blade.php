<div class='main' ng-controller='scheduleCtrl' ng-cloak>

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
						<!-- 	<md-option value="test">test</md-option>
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
			<md-list-item style="justify-content: center;background-color: rgb(245, 245, 245); color: rgba(1, 1, 1, 0.541);text-transform: uppercase;
">
			Full Schedule
			</md-list-item>
		</md-list>
	</md-content>

	<div ng-repeat='match in matches' class'schedules_list' style='max-width: 1280px; left: 0; right: 0; margin: auto; margin-top: 15px'>
	    <md-list>
			Week @{{ match.week }}

		<div class='md-whiteframe-2dp' ng-repeat='schedule in match.schedule'>


			<md-list-item style="justify-content: center;background-color: rgb(245, 245, 245); color: rgba(1, 1, 1, 0.541);
">
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
		<!-- <div  ng-repeat='weeks in match' style='background-color: white'>

			<div class='md-whiteframe-2dp' ng-repeat='matchups in weeks'>
				@{{ matchups.day }}
				<div ng-repeat='matchup in matchups'>
					<md-list-item ng-repeat='info in matchup track by $index'>
						<md-checkbox></md-checkbox>
					<div style='width: 100px;'>
						<p class='date'>
							<strong>@{{ info.time.time }}</strong>
						</p>
					</div>
					<div style='width: 150px;'>
						<p class='time'>
							@{{ info.date.time }}
						</p>
					</div>
					<div style='width: 50px; text-align: center;'>
						<img ng-src='@{{ games.teams[0].img }}' style='max-height: 30px; max-width: 30px;'>
					</div>
					<div style='width: 300px;'>
						<p style='color: rgba(0, 0, 0, 0.871);'>
							@{{ info.teams[0].id }}: @{{ info.teams[0].name }}
						</p>
					</div>
					<div style='width: 30px;'>
						<p style='text-align: center;'>
							<span> vs </span>
						</p>
					</div>
					<div style='width: 300px; margin-right: 15px'>
						<p style='text-align: end; color: rgba(0, 0, 0, 0.871);'>
							@{{ info.teams[1].id }}: @{{ info.teams[1].name }}
						</p>
					</div>
					<div style='width: 50px; text-align: center;'>
						<img ng-src='@{{info.teams[1].img}}' style='max-height: 30px; max-width: 30px;'>
					</div>
					<div style='width: 150px;'>
						<p>
							<span class='location'>
								@{{ info.court.name }}
							</span>
						</p>
					</div>
					<md-icon class='material_icons md-secondary' ng-click=''>
						mode_edit
					</md-icon>
					<md-divider></md-divider>
					</md-list-item>
				</div>
			</div>
		</div> -->
	</div>
</div>