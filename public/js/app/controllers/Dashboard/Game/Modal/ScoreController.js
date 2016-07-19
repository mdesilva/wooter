/**
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.05.02
 * Description:
 *
 */
__Wooter.controller('Dashboard/Game/Modal/ScoreController', ['$scope', '$mdDialog', '$http', 'league_id', 'game', 'type', function($scope, $mdDialog, $http, league_id, game, type) {
	$http.get('api/leagues/' + game.league_id + '/games/' + game.id)
		.success(function(response){
			var game               = response.data;
			$scope.game            = game;
			$scope.home_score     = game.home_team_score;
			$scope.visiting_score = game.visiting_team_score;
		});

	$scope.show_main = true;
	$scope.type      = type;

	$scope.setScore = function(home_team_score, visiting_team_score, type) {
		var url = 'api/leagues/' + league_id + '/games/' + game.id;

		$http.put(url, {home_team_score : home_team_score, visiting_team_score : visiting_team_score})
			.success(function(response){
				var game = response.data;
				$("md-list-item[data-game-id='" + game.id + "'").find('.home_team_score')
					.html(game.home_team_score);
				$("md-list-item[data-game-id='" + game.id + "'").find('.visiting_team_score')
					.html(game.visiting_team_score);
			});

	};

	$scope.hideScore = function() {
		$mdDialog.hide();
	};
}]);
