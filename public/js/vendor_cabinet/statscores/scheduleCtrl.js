landing.controller('scheduleCtrl', ['$scope', 'TeamFactory', 'VenueFactory', 'SlotFactory', '$compile', '$element', function($scope, TeamFactory, VenueFactory, SlotFactory, $compile, $element) {

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

}]);