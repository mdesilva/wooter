landing.controller('statScoreCtrl', ['$scope', '$mdDialog', 'PlayerFactory', 'TeamFactory', function($scope, $mdDialog, PlayerFactory, TeamFactory) {
	$scope.players = PlayerFactory.all();
	$scope.teams = [{
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

	// $scope.popTeams = function() {
	// 	for (var t = 0; t < $scope.teams.length; t++) {
	// 		for (var p = 0; p < $scope.players.length; p++) {
	// 			$scope.teams[t].players.push($scope.players[p]);
	// 		}
	// 	} 
	// };

	$scope.addScores = function($event) {
		var parentEl = angular.element(document.body);

		var matchup = this.matchup,
			matchTeams = matchup.teams;

		var matchTeam1 = matchTeams[0],
			matchTeam2 = matchTeams[1];

		var team1Players = matchTeam1.players,
			team2Players = matchTeam2.players;

		$mdDialog.show({
			clickOutsideToClose: true,
			parent: parentEl,
			targetEvent: $event,
			preserveScope: true,
			template: 
				"<md-dialog aria-label='addStats' style='width:80%; max-width: 1280px;' ng-init='popTeams()'>" +
					"<md-toolbar style='background-color: white; color: black;'>" +
						"<div class='md-toolbar-tools'>" +
							"<h4>Scores</h4>" +
							"<span flex></span>" +
							"<md-button ng-click='' style='float: right;' class='md-raised wooter-btn-primary'>UPLOAD STATS</md-button>" +
							"<md-button class='md-fab md-mini' ng-click='closeDialog()' style='background-color: white; color: grey;'> X </md-button>" +
						"</div>" +
					"</md-toolbar>" +
					"<md-dialog-content style='padding-left: 0; padding-right: 0; width: 100%;'>" +
						"<table style='width: 100%;'>" +
							"<tr style='background-color: rgb(245, 245, 245); color: rgb(1, 1, 1, 0.541); height: 50px;'>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"Team" +
										"</md-list-item>" +
									"</md-list>" +
								"</td>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"1st Half" +
										"</md-list-item>" +
									"</md-list>" +
								"</td>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"2nd Half" +
										"</md-list-item>" +
									"</md-list>" +
								"</td>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"Final" +
										"</md-list-item>" +
									"</md-list>" +
								"</td>" +
							"</tr>" +
							"<tr ng-repeat='team in teams'>" +
								// "<md-list>" +
								// 	"<td>" +
								// 		"<md-list-item>" +
								// 			"{{team.name}}" +
								// 		"</md-list-item>" +
								// 		"<md-divider></md-divider>" +
								// 	"</td>" +
								// 	"<td>" +
								// 	"<md-list-item>" +
								// 			"<md-input-container>" +
								// 				"<input type='number'>" +
								// 			"</md-input-container>" +
								// 		"</md-list-item>" +
								// 		"<md-divider></md-divider>" +
								// 	"</td>" +
								// 	"<td>" +
								// 	"<md-list-item>" +
								// 			"<md-input-container>" +
												
								// 			"</md-input-container>" +
								// 		"</md-list-item>" +
								// 	"</td>" +
								// "</md-list>" +

								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"{{ team.name }}" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</md-list>" +
								"</td>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"<input type='number' style='width: 40px;'>" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</md-list>" +
								"</td>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"<input type='number' style='width: 40px;'>" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</md-list>" +
								"</td>" +
								"<td>" +
									"<md-list>" +
										"<md-list-item>" +
											"<input type='number' style='width: 40px;'>" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</md-list>" +
								"</td>" +
							"</tr>" +
						"</table>" +
						"<table ng-repeat='teams in matchup.teams' style='width: 100%'>" +
							"<md-list><md-list-item>" +
								"<caption style='display: table-caption; color: black; font-weight: 400;'>{{ teams.name }}: Player Stats</caption>" +
							"</md-list-item></md-list>" +
							"<tr style='height: 40px; background-color: rgb(245, 245, 245);'>" +
								"<md-list color: rgb(1, 1, 1, 0.541;>" +
									"<td><md-list-item>Active</md-list-item></td>" +
									"<td><md-list-item>#</md-list-item></td>" +
									"<td><md-list-item>Player</md-list-item></td>" +
									"<td><md-list-item>FGM</md-list-item></td>" +
									"<td><md-list-item>FGA</md-list-item></td>" +
									"<td><md-list-item>FTM</md-list-item></td>" +
									"<td><md-list-item>FTA</md-list-item></td>" +
									"<td><md-list-item>3PM</md-list-item></td>" +
									"<td><md-list-item>3PA</md-list-item></td>" +
									"<td><md-list-item>PTS</md-list-item></td>" +
									"<td><md-list-item>OFF</md-list-item></td>" +
									"<td><md-list-item>DEF</md-list-item></td>" +
									"<td><md-list-item>REB</md-list-item></td>" +
									"<td><md-list-item>AST</md-list-item></td>" +
									"<td><md-list-item>TO</md-list-item></td>" +
									"<td><md-list-item>STL</md-list-item></td>" +
									"<td><md-list-item>BLK</md-list-item></td>" +
									"<td><md-list-item>PF</md-list-item></td>" +
								"</md-list>" +
							"</tr>" +
							"<tr ng-repeat='players in teams.players'>" +
								"<md-list>" +
									"<td>" +
										"<md-list-item style='height: 48px;'>" +
											"<md-checkbox></md-checkbox>" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</td>" +
									"<td>" +
										"<md-list-item>" +
											"{{players.jersey}}" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</td>" +
									"<td>" +
										"<md-list-item>" +
											"{{players.fName}} {{players.lName}}" +
										"</md-list-item>" +
										"<md-divider></md-divider>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +
									"<td>" +
										"<md-list>" +
											"<md-list-item>" +
												"<input type='number' style='width: 40px;'>" +
											"</md-list-item>" +
											"<md-divider></md-divider>" +
										"</md-list>" +
									"</td>" +

								"</md-list>" +
							"</tr>" +
						"</table>" +
					"</md-dialog-content>" +
				"</md-dialog>",
			fullscreen: true,
			locals: {
				teams: $scope.teams,
				matchup: $scope.matchup
			},
			controller: function thisCtrl($scope, $mdDialog) {
				$scope.teams = matchTeams;
				$scope.matchup = matchup;
				$scope.team1Players = team1Players;
				$scope.team2Players = team2Players;

				$scope.closeDialog = function() {
					$mdDialog.hide();
				};
			}
		});
	};
}]);