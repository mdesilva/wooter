landing.controller('scheduleCtrl', ['$scope', '$rootScope', 'TeamFactory', 'VenueFactory', 'SlotFactory', 'PlayerFactory', '$compile', '$element', '$mdDialog', '$q', '$timeout', function($scope, $rootScope, TeamFactory, VenueFactory, SlotFactory, PlayerFactory, $compile, $element, $mdDialog, $q, $timeout) {


	$scope.players = PlayerFactory.all();




	$scope.teams = TeamFactory.all();
	$scope.bye = TeamFactory.bye();
	$scope.venues = VenueFactory.all();
	$scope.timeSlots = SlotFactory.all();

	// League Date info
	$scope.startDate = new Date(2016, 1, 21); // Start date is hard set here. Will come from league creation option menu
	$scope.endDate = new Date(2016, 4, 9); // Same for this end date.
	$scope.lengthDays = Math.floor(($scope.endDate - $scope.startDate) / 1000 / 60 / 60 / 24); // Lenght in days. Might not need.
	$scope.lengthInWeeks = Math.floor($scope.lengthDays / 7); // Number of weeks in a season.
	$scope.weekNum = 1;

	// League Info
	$scope.matches = []; // Matches array. Used for entire season of matches.
	$scope.totalTeams = $scope.teams.length;
	$scope.teamOpponents = $scope.totalTeams - 1;
	$scope.matchesPerWeek = 6; // Matches per week, total
	$scope.matchesPerTeamPerWeek = $scope.totalTeams / 2;
	$scope.gamesPerWeek = 1;

	$scope.availSlotsPerWeek = $scope.availSlotsPerDay * 7; // Probably won't need
	$scope.availSlotsPerDay = 1; // Available slots per day. Hard set. Will change, obviously.
	$scope.allMatchID = 1;
	$scope.allWeekMatches = []; // Storage array for all weekly matchups.

	// Main schedule generation function.
	// If there are an odd number of teams, a BYE week team will be 
	// pushed into the teams array to be sure the number is even.
	// Each match up from the allWeeksMatchup array is then removed,
	// one by one and set equal to the corresponding open slot as a 
	// matchup.
	$scope.genSchedule = function() {
		$scope.matches = [];
		$scope.setupSchedule();
		
		if ($scope.teams.length % 2 == 1) {
			$scope.teams.push($scope.bye);
			$scope.teamOpponents = $scope.teams.length - 1;
		}
		// $scope.shuffleTeams();
		for (var w = 0; w < $scope.lengthInWeeks; w++) {
			$scope.weekSchedule();
			for (var d = 0; d < 7; d++) {
				for (var h = 0; h < $scope.availSlotsPerDay; h++) {
					$scope.matches[w].schedule[d].slots[h].teams = $scope.allWeekMatches.shift();
				}
			}
		}
		$scope.createSlot();
	};

	// Generates the schedule for each week individually.
	// Iterates and sets team 1 equal to the corresponding team in that 
	// index.
	// Second team is set by using the last team in the teams array.
	// Teams are then pushed into matchUp array as a hash
	// then stored in an array to be pushed into matchups.
	// Team order is then rotated after each round of matchUps
	$scope.weekSchedule = function() {
		$scope.allWeekMatches = [];

		for (var i = 0; i < $scope.gamesPerWeek; i++) {
			for (var j = 0; j < $scope.matchesPerTeamPerWeek; j++) {
				team_1 = $scope.teams[j];

				if (($scope.teams.length - j) === $scope.teams.length) {
					team_2 = $scope.teams[($scope.teams.length - 1)];
				} else {
					team_2 = $scope.teams[($scope.teams.length - (j + 1))];
				}
				var matchUp = [];
				matchUp.push(team_1, team_2);
				$scope.allWeekMatches.push(matchUp);
			}
			$scope.rotateTeamOrder();
		}
	};

	$scope.weekSlots = []; // Array used to store weekly information
						   // to be pushed into the corresponding
						   // index position in the matches array.

	// Scaffolds schedule array with necessary parameters.
	// For the length of the season measured in number of weeks,
	// each week will consist of the week number and schedule array.
	// Then for each week each individual slot will be pushed into the 
	// corresponding day based upon how many available slots exist.
	$scope.setupSchedule = function() {
		for (var w = 0; w < numWeeks; w++) {
			$scope.weekSlots = [];
			var year = week.getFullYear(),
				month = week.getMonth(),
				day = week.getDate();
			week = new Date(year, month, day);

			$scope.matches.push({
				week: (w + 1),
				schedule: []
			});
			for (var d = 0; d < 7; d++) {
				var currentDay = new Date(year, month, day + (w * 7) + d);
				$scope.matches[w].schedule[d] = {
					day: currentDay,
					slots: []
				};

				for (var h = 0; h < $scope.availSlotsPerDay; h++) {
					currentDay.setHours(18 + h);
					var slot = {
						court: $scope.venues[(Math.floor(Math.random() * 7))], // For now, pick random number to set venue
						time: {
							// time: currentDay.toTimeString()
							time: currentDay.toLocaleTimeString()
						},
						teams: []
					};
					$scope.matches[w].schedule[d].slots.push(slot);
				}
			}
		}
	};

	$scope.wkNum = '';
	$scope.dayNum = '';
	$scope.newTeam1 = '';
	$scope.newTeam2 = '';

	$scope.createSlot = function() {
		var date = $scope.matches[3].schedule[3].day;
		var found = false;
		$scope.wkNum = '';
		$scope.dayNum = '';
		while (found !== true) {
			for (var w = 0; w < $scope.matches.length; w++) {
				for (var d = 0; d < 7; d++) {
					if ($scope.matches[w].schedule[d].day == date) {
						$scope.setNewTeams();
						$scope.wkNum = $scope.matches[w].week - 1;
						$scope.dayNum = $scope.matches[w].schedule[d].day.getDay();
						found = true;
						date.setHours(date.getHours() + 1);

						$scope.matches[$scope.wkNum].schedule[$scope.dayNum].slots.push({
							court: $scope.venues[(Math.floor(Math.random() * 7))],
							time: date,
							teams: [$scope.newTeam1, $scope.newTeam2]
						});
						{break;}
						console.log($scope.newTeam1, $scope.newteam2);
					}
				}
			}
		}
	};

	$scope.setNewTeams = function() {
		$scope.newTeam1 = '';
		$scope.newTeam2 = '';
		$scope.newTeam1 = $scope.teams[(Math.floor(Math.random() * $scope.teams.length))];
		$scope.newteam2 = $scope.teams[(Math.floor(Math.random() * $scope.teams.length))];
	};


	$scope.rotateTeamOrder = function() {
		$scope.teams.move(($scope.teamOpponents), 1);
	};

	$scope.shuffleTeams = function() {
		var currentIndex = ($scope.teams.length - 1),
			tempValue, randomIndex;
		for (f = currentIndex; f > 0; f--) {
			randomIndex = Math.floor(Math.random() * currentIndex);
			tempValue = $scope.teams[currentIndex];
			$scope.teams[currentIndex] = $scope.teams[randomIndex];
			$scope.teams[randomIndex] = tempValue;
		}
	};

	Array.prototype.move = function(old_index, new_index) {
		if (new_index >= this.length) {
			var k = new_index - this.length;
			while ((k--) + 1) {
				this.push(undefined);
			}
		}
		this.splice(new_index, 0, this.splice(old_index, 1)[0]);
	};



	$scope.createPlayer = function($event) {
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			clickOutsideToClose: true,
			parent: parentEl,
			targetEvent: $event,
			preserveScope: true,
			template:
				"<md-dialog class='modal_AT' aria-label='createMatch' style='min-width: 400px;'>" +
					"<md-dialog-content>" +
						"<h4>Add Player</h4>" +
						"<form ng-submit='$event'>" +
							// Fname
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>First Name</label>" +
										"<input name='playerFname' ng-model='playerFname' required minlength='4'>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +

							// Lname
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>Last Name</label>" +
										"<input name='playerLname' ng-model='playerLname' required minlength='4'>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +



							// Email
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>Email</label>" +
										"<input name='playerEmail' ng-model='playerEmail' required minlength='4'>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +

							// Phone
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>Phone Number</label>" +
										"<input name='playerPhone' ng-model='playerPhone' required minlength='4'>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +


							// Add Team
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='setDivision'>" +
										"<label>Select Team</label>" +
										"<md-select ng-model='newVenue' aria-label=''>" +
											"<md-option ng-repeat='venue in venues' value='{{venue}}'>" +
												"{{ venue.name }}" +
											"</md-option>" +
										"</md-select>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +


							"<md-button class='modal_buttons'>" +
								"Add Player" +
							"</md-button>" +							
							"<md-button class='modal_buttons'>" +
								"Cancel" +
							"</md-button>" +							

						"</form>" +
					"</md-dialog-content>" +
				"</md-dialog>",
			
		});
	};

	$scope.createTeam = function($event) {
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			clickOutsideToClose: true,
			parent: parentEl,
			targetEvent: $event,
			preserveScope: true,
			template:
				"<md-dialog class='modal_AT' aria-label='createMatch' style='min-width: 400px;'>" +
					"<md-dialog-content>" +
						"<h4>Add Team</h4>" +
						"<form ng-submit='$event'>" +
							// Teams
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>Team Name</label>" +
										"<input name='companyName' ng-model='companyName' required minlength='4'>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +
							// Venue
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<md-input-container class='modal_field' id='setDivision'>" +
										"<label>Select Division</label>" +
										"<md-select ng-model='newVenue' aria-label=''>" +
											"<md-option ng-repeat='venue in venues' value='{{venue}}'>" +
												"{{ venue.name }}" +
											"</md-option>" +
										"</md-select>" +
									"</md-input-container>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +
							"<md-button class='modal_buttons'>" +
								"Add Team" +
							"</md-button>" +							
							"<md-button class='modal_buttons'>" +
								"Cancel" +
							"</md-button>" +							

						"</form>" +
					"</md-dialog-content>" +
				"</md-dialog>",
			
		});
	};



	// <form method="post" action="https://css-tricks.com/examples/DragAndDropFileUploading//?" enctype="multipart/form-data" novalidate class="box">

		
	// 	<div class="box__input">
	// 		<svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"/></svg>
	// 		<input type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple />
	// 		<label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
	// 		<button type="submit" class="box__button">Upload</button>
	// 	</div>

		
	// 	<div class="box__uploading">Uploading&hellip;</div>
	// 	<div class="box__success">Done! <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?" class="box__restart" role="button">Upload more?</a></div>
	// 	<div class="box__error">Error! <span></span>. <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?" class="box__restart" role="button">Try again!</a></div>
	// </form>


// 		<div class="box__uploading">Uploading&hellip;</div>
// 		<div class="box__success">Done! <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?submit-on-demand" class="box__restart" role="button">Upload more?</a></div>
// 		<div class="box__error">Error! <span></span>. <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?submit-on-demand" class="box__restart" role="button">Try again!</a></div>

	$scope.createVideo = function($event) {
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			clickOutsideToClose: true,
			parent: parentEl,
			targetEvent: $event,
			preserveScope: true,
			template:
				"<md-dialog class='modal_AV' aria-label='createMatch' style='min-width: 600px;'>" +
					"<md-dialog-content>" +
						"<h4>Add Video(s)</h4>" +
							// Teams
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<form method='post' action='https://css-tricks.com/examples/DragAndDropFileUploading//?' enctype='multipart/form-data' novalidate class='box'>" +
										"<div class='box__input'>" +
											"<input type='file' name='files[]' id='file' class='box__file' data-multiple-caption='{count} files selected' multiple />" +
											"<label for='file' class='raised'><strong><img style='width: 20px; margin-right: 10px;' src='../img/dashboard/upload.png' /> SELECT VIDEO(S)</i></strong></label>" +
											"<p><span>OR</span></p>" +
											"<p>Drag & Drop</p>" +
										"</div>" +
									"</form>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +

							"<div class='custom_hr'></div>" +

							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +


								"<div layout='column' flex='40'>" +
									"<img src='' alt='' class='add_thumbnails' />" +
								"</div>" +


								"<div layout='column' flex='50'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>Title</label>" +
										"<input name='videoName' ng-model='videoName' required minlength='4'>" +
									"</md-input-container>" +

									"<md-input-container class='modal_field' id='setDivision'>" +
										"<label>Category</label>" +
										"<md-select ng-model='videoCategory' aria-label=''>" +
											"<md-option ng-repeat='venue in venues' value='{{venue}}'>" +
												"{{ venue.name }}" +
											"</md-option>" +
										"</md-select>" +
									"</md-input-container>" +


									"<md-input-container class='modal_field' id='setDivision'>" +
										"<label>Select Week</label>" +
										"<md-select ng-model='videoWeek' aria-label=''>" +
											"<md-option ng-repeat='venue in venues' value='{{venue}}'>" +
												"{{ venue.name }}" +
											"</md-option>" +
										"</md-select>" +
									"</md-input-container>" +
								"</div>" +



								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +



							"<div class='custom_hr'></div>" +

							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +


								"<div layout='column' flex='40'>" +
									"<img src='' alt='' class='add_thumbnails' />" +
								"</div>" +


								"<div layout='column' flex='50'>" +
									"<md-input-container class='modal_field' id='addTeamName'>" +
										"<label>Title</label>" +
										"<input name='videoName' ng-model='videoName' required minlength='4'>" +
									"</md-input-container>" +

									"<md-input-container class='modal_field' id='setDivision'>" +
										"<label>Category</label>" +
										"<md-select ng-model='videoCategory' aria-label=''>" +
											"<md-option ng-repeat='venue in venues' value='{{venue}}'>" +
												"{{ venue.name }}" +
											"</md-option>" +
										"</md-select>" +
									"</md-input-container>" +


									"<md-input-container class='modal_field' id='setDivision'>" +
										"<label>Select Week</label>" +
										"<md-select ng-model='videoWeek' aria-label=''>" +
											"<md-option ng-repeat='venue in venues' value='{{venue}}'>" +
												"{{ venue.name }}" +
											"</md-option>" +
										"</md-select>" +
									"</md-input-container>" +
								"</div>" +



								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +


							
							"<md-button class='modal_buttons'>" +
								"Add Video(s)" +
							"</md-button>" +							
							"<md-button class='modal_buttons'>" +
								"Cancel" +
							"</md-button>" +
					"</md-dialog-content>" +
				"</md-dialog>",
			
		});
	};


	$scope.createPhoto = function($event) {
		var parentEl = angular.element(document.body);
		$mdDialog.show({
			clickOutsideToClose: true,
			parent: parentEl,
			targetEvent: $event,
			preserveScope: true,
			template:
				"<md-dialog class='modal_AT' aria-label='createMatch' style='min-width: 500px;'>" +
					"<md-dialog-content>" +
						"<h4>Add Team</h4>" +
							// Teams
							"<div layout='row'>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
								"<div layout='column' flex='90'>" +
									"<form method='post' action='https://css-tricks.com/examples/DragAndDropFileUploading//?' enctype='multipart/form-data' novalidate class='box'>" +
										"<div class='box__input'>" +
											"<input type='file' name='files[]' id='file' class='box__file' data-multiple-caption='{count} files selected' multiple />" +
											"<label for='file'><strong>Choose or Drag & Drop a File</strong>.</label>" +
											"<button type='submit' class='box__button'>Upload</button>" +
										"</div>" +
									"</form>" +
								"</div>" +
								"<div layout='column' flex='5'>" +
								"</div>" +
							"</div>" +

					"</md-dialog-content>" +
				"</md-dialog>",
			
		});
	};


}]);