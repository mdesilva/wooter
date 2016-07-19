landing.factory('VenueFactory', [function() {

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

	return {
		all: function() {
			return venues;
		}
	};
}]);