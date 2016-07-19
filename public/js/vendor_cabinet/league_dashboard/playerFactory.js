landing.factory('PlayerFactory', [function() {

	// var players = [{
	// 	id: 1,
	// 	fname: 'Alex',
	// 	lname: 'Aleksandrovski',
	// 	phone: '555-555-5555',
	// 	number: 5,
	// 	team: [],
	// 	img: '/img/landing/tempVendCab/image_1.png',
	// }, {
	// 	id: 2,
	// 	fname: 'Alban',
	// 	lname: 'Toci',
	// 	phone: '800-867-5309',
	// 	number: 12,
	// 	team: [],
	// 	img: '/img/landing/tempVendCab/image_2.jpg'
	// }, {
	// 	id: 3,
	// 	fname: 'Alex',
	// 	lname: 'Kagan',
	// 	phone: '212-922-9111',
	// 	number: 23,
	// 	team: [],
	// 	img: '/img/landing/tempVendCab/image_3.jpg'
	// }, {
	// 	id: 4,
	// 	fname: 'Sadam',
	// 	lname: 'Hussein',
	// 	phone: '123-123-1234',
	// 	number: 15,
	// 	team: [],
	// 	img: '/img/landing/tempVendCab/image_4.jpg'
	// }];

	// return {
	// 	all: function() {
	// 		return players;
	// 	},
	// };

	var players = [{
		id: 1,
		fName: "Alex",
		lName: "Kagan",
		pictureLink: "/img/landing/tempVendCab/image_1.png",
		jersey: 3,
		position: "Shooting Guard",
		city: "Staten Island",
		phone: '123-123-1234',		
		team: "Wooter"
	}, {
		id: 2,
		fName: "David",
		lName: "Gluck",
		pictureLink: "/img/landing/tempVendCab/image_2.jpg",
		position: 'Power Forward',
		jersey: 23,
		city: 'Staten Island',
		phone: '123-123-1234',		
		team: "Knicks"		
	}, {
		id: 3,
		fName: "Michael",
		lName: "Isakov",
		pictureLink: "/img/landing/tempVendCab/image_3.jpg",
		jersey: 12,
		position: 'Center',
		city: 'Staten Island',
		phone: '123-123-1234',		
		team: "Nets"
	}, {
		id: 4,
		fName: "Eric",
		lName: "Rho",
		pictureLink: "/img/landing/tempVendCab/image_2.jpg",
		jersey: 16,
		position: 'Point Guard',
		city: 'Morristown',
		phone: '123-123-1234',		
		team: "Rangers"
	}];

	return {
		all: function() {
			return players;
		}
	};
}]);