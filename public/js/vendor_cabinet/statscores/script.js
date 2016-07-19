// Test JS for scheduleCtrl

// Data
var teams = [{
	id: 1,
	name: 'Flying Squirrels'
}, {
	id: 2,
	name: 'Banana Hammocks'
}, {
	id: 3,
	name: 'Trouser Bandits'
}, {
	id: 4,
	name: 'Alabama Slammers'
}, {
	id: 5,
	name: 'Crotch Rockets'
}, {
	id: 6,
	name: 'Pussy Willows'
}, {
	id: 7,
	name: 'Shit Stains'
}, {
	id: 8,
	name: 'Giant Douches'
}, {
	id: 9,
	name: 'Fudge Packers'
}, {
	id: 10,
	name: 'Twatcannons'
}, {
	id: 11,
	name: 'Cock Knockers'
}];

var venues = [{
	id: 1,
	name: 'Court_1',
	address: {
		street: '123 Main Street',
		city: 'New York',
		state: 'NY',
		zip: '10001'
	}
}, {
	id: 2,
	name: 'Court_2',
	address: {
		street: '582 Whatever Ave',
		city: 'Hoboken',
		state: 'NJ',
		zip: '07030'
	}
}, {
	id: 3,
	name: 'Something or Whatever Court',
	address: {
		street: '9303 Balls Court',
		city: 'Chester',
		state: 'NJ',
		zip: '07930'
	}
}, {
	id: 4,
	name: 'Another Court or Something',
	address: {
		street: '1300 Nipple Place',
		city: 'Parsippany',
		state: 'NJ',
		zip: '07054'
	}
}, {
	id: 5,
	name: 'Fifth Court',
	address: {
		street: '876 Blah Street',
		city: 'Fake',
		state: 'NY',
		zip: '07950'
	}
}, {
	id: 6,
	name: 'My Place',
	address: {
		street: '14 Willowbank Road',
		city: 'Aberdeen',
		state: 'Aberdeenshire',
		zip: 'AB11 6YH'
	}
}, {
	id: 7,
	name: 'I Need More Coffee',
	address: {
		street: '6845 Randome Road',
		city: 'New York',
		state: 'NY',
		zip: '10001'
	}
}, {
	id: 8,
	name: 'Only a Few Courts Left',
	address: {
		street: '123 Test Ave',
		city: 'Just Another Town',
		state: 'NJ',
		zip: '07930'
	}
}];

var timeSlots = [{
	day: 'Sunday',
	slots: []
}, {
	day: 'Monday',
	slots: []
}, {
	day: 'Tuesday',
	slots: []
}, {
	day: 'Wednesday',
	slots: []
}, {
	day: 'Thursday',
	slots: []
}, {
	day: 'Friday',
	slots: []
}, {
	day: 'Saturday',
	slots: []
}];

var sun = timeSlots[0],
	mon = timeSlots[1],
	tues = timeSlots[2],
	wed = timeSlots[3],
	thurs = timeSlots[4],
	fri = timeSlots[5],
	sat = timeSlots[6];

//________________________________________________________________________________

// Date/Time stuff
var startDate = new Date(2016, 1, 21);
var endDate = new Date(2016, 4, 9);
var lengthDays = Math.floor((endDate - startDate) / 1000 / 60 / 60 / 24); // length of season in total days
var numWeeks = Math.floor(lengthDays / 7); // length of season in whole weeks
var gameLength = 55; // length of each match in minutes
var weeks = numWeeks + ' weeks and ' + days + ' days.';
var days = lengthDays % 7;
var length = numWeeks + ' ' + 'weeks' + ' and ' + days + ' days.'; // Test
var hours = [];


var matches = [];
var totalTeams = teams.length;
var teamOpponents = totalTeams - 1;
var matchesPerWeek = 6; // Each team plays once per week.
var matchesPerTeamPerWeek = totalTeams / 2;
var gamesPerWeek = 1;
var divisions = [];
var numDivs = 1;
var teamsPerDiv = totalTeams / numDivs;
var bye = {
	id: totalTeams + 1,
	name: 'BYE week'
};
var matches = [];
var availSlotsPerDay = 1;
var availSlotsTotal = '';
var totalNumMatches = matchesPerWeek * numWeeks;
var matchID = 0;
var allSlots = [];
var allWeekMatches = [];
var thisWeek = startDate;

var weekSlots = [];
var week = startDate;

var genSchedule = function() {
	matches = [];
	setupSchedule();

	if (teams.length % 2 == 1) {
		teams.push(bye);
		teamOpponents = teams.length - 1;
	}

	for (var w = 0; w < numWeeks; w++) {
		weekSchedule();
		for (var d = 0; d < 7; d++) {
			for (var h = 0; h < availSlotsPerDay; h++) {
				matches[w].schedule[d].slots[h].teams = allWeekMatches.shift();
			}
		}
	}
	// createSlot();
	console.log(matches[0].schedule[0]);
};

// Create schedule for one week.
// Start with first week.
var weekSchedule = function() {
	allWeekMatches = [];
	for (var i = 0; i < gamesPerWeek; i++) {
		for (var j = 0; j < matchesPerTeamPerWeek; j++) {
			team_1 = teams[j];

			if ((teams.length - j) == teams.length) {
				team_2 = teams[(teams.length - 1)];
			} else {
				team_2 = teams[(teams.length - (j + 1))];
			}
			var matchUp = [];
			matchUp.push(team_1, team_2);
			allWeekMatches.push(matchUp);
		}
		rotateTeamOrder();
	}
};

// Scaffold schedule 
var setupSchedule = function() {
	matches = [];

	for (var w = 0; w < numWeeks; w++) {
		weekSlots = [];
		var year = week.getFullYear(),
			month = week.getMonth(),
			day = week.getDate();
		week = new Date(year, month, day);

		matches.push({
			week: (w + 1),
			schedule: []
		});
		for (var d = 0; d < 7; d++) {
			var currentDay = new Date(year, month, day + (w * 7) + d);
			matches[w].schedule[d] = {
				// day: currentDay.toDateString(),
				day: currentDay,
				slots: []
			};
			for (var h = 0; h < availSlotsPerDay; h++) {
				currentDay.setHours(18 + h);
				var slot = {
					court: venues[(Math.floor(Math.random() * 7))],
					time: {
						time: currentDay.toTimeString()
					},
					teams: []
				};
				matches[w].schedule[d].slots.push(slot);
			}
		}
	}
};

var targetDate = '';
var wkNum = '';

var createSlot = function() {
	var date = matches[3].schedule[3].day;
	var found = false;
	while (found !== true) {
		for (var w = 0; w < matches.length; w++) {
			for (var d = 0; d < 7; d++) {
				if (matches[w].schedule[d].day == date) {
					setNewTeams();
					wkNum = matches[w].week - 1;
					dayNum = matches[w].schedule[d].day.getDay();
					found = true;
					date.setHours(date.getHours() + 1);

					matches[wkNum].schedule[dayNum].slots.push({
						court: venues[(Math.floor(Math.random) * 8)],
						time: date,
						teams: 	[newTeam1, newTeam2]
					});
					{break;}
				}
			}
		}
	}
};

var setNewTeams = function() {
	newTeam1 = teams[(Math.floor(Math.random() * teams.length))];
	newTeam2 = teams[(Math.floor(Math.random() * teams.length))];
};

var addMatch = function() {
	setNewTeams();
	// teams = [{
		// id: newTeam1.id,
		// name: newTeam1.name
	// }, {
		// id: newTeam2.id, 
		// name: newTeam2.name
	// }];
};

var rotateTeamOrder = function() {
	teams.move((teamOpponents), 1);
};

var shuffleTeams = function() {
	var currentIndex = (teams.length - 1),
		tempValue, randomIndex;
	for (var f = currentIndex; f > 0; f--) {
		randomIndex = Math.floor(Math.random() * currentIndex);
		tempValue = teams[currentIndex];
		teams[currentIndex] = teams[randomIndex];
		teams[randomIndex] = tempValue;
	}
	for (var i = 0; i < teams.length; i++) {
		console.log(teams[i]);
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