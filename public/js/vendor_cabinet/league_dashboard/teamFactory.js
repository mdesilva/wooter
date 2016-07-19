landing.factory('TeamFactory', [function() {

	// var teams = [{
	// 	id: 1,
	// 	name: 'Flying Squirrels'
	// }, {
	// 	id: 2,
	// 	name: 'Banana Hammocks'
	// }, {
	// 	id: 3,
	// 	name: 'Trouser Bandits'
	// }, {
	// 	id: 4,
	// 	name: 'Alabama Slammers'
	// }, {
	// 	id: 5,
	// 	name: 'Crotch Rockets'
	// }, {
	// 	id: 6,
	// 	name: 'Pussy Willows'
	// }, {
	// 	id: 7,
	// 	name: 'Shit Stains'
	// }, {
	// 	id: 8,
	// 	name: 'Giant Douches'
	// }, {
	// 	id: 9,
	// 	name: 'Fudge Packers'
	// }, {
	// 	id: 10,
	// 	name: 'Twatcannons'
	// }, {
	// 	id: 11,
	// 	name: 'Cock Knockers'
	// }, {
	// 	id: 12,
	// 	name: 'Butt Pirates'
	// }];

	var teams = [{
		id: 1,
		name: 'New Jersey Devils',
		img: '/img/landing/schedule/devils.png',
		wins: 10,
		loss: 8,
		ties: 2,
		divs: 1
	}, {
		id: 2,
		name: 'FC Barcelona',
		img: '/img/landing/schedule/barca.png',
		wins: 8,
		loss: 10,
		ties: 2,
		divs: 1
	}, {
		id: 3,
		name: 'New York Jets',
		img: '/img/landing/schedule/jets.png',
		wins: 12,
		loss: 3,
		ties: 7,
		divs: 1
	}, {
		id: 4,
		name: 'New Jersey Nets',
		img: '/img/landing/schedule/nets.png',
		wins: 3,
		loss: 12,
		ties: 7,
		divs: 2
	}, {
		id: 5,
		name: 'Liverpool FC',
		img: '/img/landing/schedule/liverpool.png',
		wins: 14,
		loss: 3,
		ties: 3,
		divs: 2
	}, {
		id: 6,
		name: 'Ohio State Buckeyes',
		img: '/img/landing/schedule/osu.png',
		wins: 3,
		loss: 14,
		ties: 3,
		divs: 2
	}, {
		id: 7,
		name: 'New York Yankees',
		img: '/img/landing/schedule/yankees.png',
		wins: 11,
		loss: 4,
		ties: 5,
		divs: 3
	}, {
		id: 8,
		name: 'A.S. Roma',
		img: '/img/landing/schedule/roma.png',
		wins: 9,
		loss: 5,
		ties: 6,
		divs: 3
	}, {
		id: 9,
		name: 'Confederação Brasileira de Futebol ',
		img: '/img/landing/schedule/brasil.png',
		wins: 6,
		loss: 7,
		ties: 7,
		divs: 3
	}, {
		id: 10,
		name: 'University of Aberdeen',
		img: '/img/landing/schedule/aberdeen_u.png',
		wins: 7,
		loss: 2,
		ties: 11,
		divs: 3
	}, {
		id: 11,
		name: 'Scotland National Team',
		img: '/img/landing/schedule/scotland.png',
		wins: 20,
		loss: 0,
		ties: 0,
		divs: 1
	}];

	var bye = {
		id: teams.length + 1,
		name: 'BYE week',
		img: '/img/landing/schedule/bye.png'
	};

	return {
		all: function() {
			return teams;
		},
		bye: function() {
			return bye;
		}
	};

	// 	var teams = [{
	// 	id: 1,
	// 	name: 'Flying Squirrels'
	// }, {
	// 	id: 2,
	// 	name: 'Banana Hammocks'
	// }, {
	// 	id: 3,
	// 	name: 'Trouser Bandits'
	// }, {
	// 	id: 4,
	// 	name: 'Alabama Slammers'
	// }, {
	// 	id: 5,
	// 	name: 'Crotch Rockets'
	// }, {
	// 	id: 6,
	// 	name: 'Pussy Willows'
	// }, {
	// 	id: 7,
	// 	name: 'Shit Stains'
	// }, {
	// 	id: 8,
	// 	name: 'Giant Douches'
	// }, {
	// 	id: 9,
	// 	name: 'Fudge Packers'
	// }, {
	// 	id: 10,
	// 	name: 'Twatcannons'
	// }, {
	// 	id: 11,
	// 	name: 'Cock Knockers'
	// }];

	// return {
	// 	all: function() {
	// 		return teams;
	// 	},
	// };

}]);