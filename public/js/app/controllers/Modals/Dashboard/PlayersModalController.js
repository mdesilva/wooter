/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.23
 * Description:
 *
 */
__Wooter.controller('Modals/Dashboard/Players', ['$scope', 'Page', '$stateParams', '$mdDialog', 'API', 'Notify', function ($scope, Page, $stateParams, $mdDialog, API, Notify) {

    var $leaguePlayersAPI = API.exec('leaguePlayers');
    var $teamPlayersAPI = API.exec('teamPlayers');
    var $playerTeamsAPI = API.exec('playerTeams');

    var leagueId = $stateParams.league_id;

    Page.stylesheets([
        '/css/dashboard/players.css'
    ]);

    $scope.cancel = function() { $mdDialog.hide(); };

    var updatePlayers = function(notifyMessage, notifyStatus) {

        if ($scope.teamToFilter != 'all') {
            $teamPlayersAPI.get({teamId: $scope.teamToFilter, league_id: leagueId}, function (response) {
                $scope.synchronize(response.data);
                Notify(notifyMessage, notifyStatus);
            });
        } else {
            $leaguePlayersAPI.get({leagueId: leagueId}, function (response) {
                $scope.synchronize(response.data);
                Notify(notifyMessage, notifyStatus);
            });
        }
    };

    $scope.addPlayerInModal = function() {
        var is_error = false;

        if (!$scope.playerFirstName) {
            Notify({
                message: 'First Name Required',
                inverse: true,
                type: 'error'
            });
            is_error = true;
        }
        if (!$scope.playerLastName) {
            Notify({
                message: 'Last Name Required',
                inverse: true,
                type: 'error'
            });
            is_error = true;
        }
        if (!$scope.playerEmail) {
            Notify({
                message: 'Email Required',
                inverse: true,
                type: 'error'
            });
            is_error = true;
        }

        if (!$scope.playerPhone) {
            Notify({
                message: 'Phone Number Required',
                inverse: true,
                type: 'error'
            });
            is_error = true;
        }
        if (is_error) {
            return;
        }

        loading();

        $leaguePlayersAPI.save({leagueId: leagueId,
                                first_name: $scope.playerFirstName,
                                last_name: $scope.playerLastName,
                                phone: $scope.playerPhone, 
                                email: $scope.playerEmail,
                                jersey: $scope.playerJersey}, function(response)
        {

            $mdDialog.hide();

            updatePlayers($scope.playerFirstName + ' ' + $scope.playerLastName + ' was successfully added to the league.', 'success');

        }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            loaded();
            if (response.data.first_name) {
                Notify({
                    message: response.data.first_name[0],
                    inverse: true,
                    type: 'error'
                });
            }
            if (response.data.last_name) {
                Notify({
                    message: response.data.last_name[0],
                    inverse: true,
                    type: 'error'
                });
            }

            if (response.data.phone) {
                Notify({
                    message: response.data.phone[0],
                    inverse: true,
                    type: 'error'
                });
            }

            if (response.data.email) {
                Notify({
                    message: response.data.email[0],
                    inverse: true,
                    type: 'error'
                });
            }
            if (response.data.error) {
                Notify({
                    message: response.data.error.message,
                    inverse: true,
                    type: 'error'
                });
            }
        });
    };

    $scope.editPlayerInModal = function(player) {
        loading();

        $playerTeamsAPI.put({teamId: player.current_team.id, playerId: player.id, league_id: leagueId,
                                jersey: player.player_info.jersey}, function(response)
        {

            $mdDialog.hide();

            updatePlayers(player.first_name + ' ' + player.last_name + ' was successfully edited.', 'success');

        }, function errorCallback(response) {
            loaded();
        });
    };

    $scope.removePlayerInModal = function(player) {
        loading();

        $leaguePlayersAPI.delete({leagueId: leagueId, playerId: player.id}, function(response) {
            updatePlayers('The player ' + player.first_name + ' ' + player.last_name  + ' was successfully deleted from the league', 'success');
        });

        $mdDialog.hide();
    };

    $scope.movePlayerInModal = function(player) {
        loading();

        $playerTeamsAPI.save({playerId: player.id, team_id: $scope.teamIdToMove, league_id: leagueId}, function(response) {
            updatePlayers(player.first_name + ' ' + player.last_name  + ' was successfully moved to '  + response.data.name, 'success');
        });

        $mdDialog.hide();
    };

    $scope.movePlayersInModal = function() {
        loading();
        var playersToMove = $scope.playersToMove;
        var teamIdToMove = $scope.teamIdToMove;

        $teamPlayersAPI.save({teamId: teamIdToMove, players: playersToMove, league_id: leagueId}, function() {
            updatePlayers('Players successfully moved to the team', 'success');
        });

        $mdDialog.hide();
    };

}]);
