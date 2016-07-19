landing.factory('SlotFactory', [function() {

	var timeSlots = [{
		day: ['Sunday'],
		slots: []
	}, {
		day: ['Monday'],
		slots: []
	}, {
		day: ['Tuesday'],
		slots: []
	}, {
		day: ['Wednesday'],
		slots: []
	}, {
		day: ['Thursday'],
		slots: []
	}, {
		day: ['Friday'],
		slots: []
	}, {
		day: ['Saturday'],
		slots: []
	}];

	return {
		all: function() {
			return timeSlots;
		}
	};

}]);