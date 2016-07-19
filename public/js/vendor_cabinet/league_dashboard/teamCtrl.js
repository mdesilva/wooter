landing.controller('teamCtrl', ['$scope', 'PlayerFactory', 'TeamFactory', function($scope, PlayerFactory, TeamFactory) {
	$scope.players = PlayerFactory.all();
	$scope.teams = TeamFactory.all();

	$scope.addPlayerToTeam = function() {
		console.log($scope.teams);
		console.log($scope.players);
	};
}]);