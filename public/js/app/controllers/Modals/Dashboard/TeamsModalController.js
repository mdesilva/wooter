/*
 * Created by {your name}.
 * User: {slack, skype}
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.03.23
 * Description:
 *
 */
__Wooter.controller('Modals/Dashboard/Teams', ['$scope', 'Page', '$stateParams', '$mdDialog', 'Leagues', 'API', 'Notify', function ($scope, Page, $stateParams, $mdDialog, Leagues, API, Notify) {

    var $leaguesAPI = API.exec('leagues');
    var $leagueDivisionsAPI = API.exec('leagueDivisions');
    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $teamsAPI = API.exec('teams');
    var $divisionTeamsAPI = API.exec('divisionTeams');

    console.log($scope);

    /**
     * Get List of divisions for the league
     */
    $leagueDivisionsAPI.get({leagueId: $stateParams.league_id}, function (response) {
        $scope.divisions = response.data;
    });

    var leagueId = $stateParams.league_id;

    /*
     * Put here Action and Scopes
     */
    Page.scripts([
    ]);

    $scope.labels = [];

    $scope.cancel = function() { $mdDialog.hide(); };

    $scope.leagues = Leagues;

    $scope.leagueId = leagueId;

    var updateTeams = function(notifyMessage, notifyStatus) {
        if ($scope.divisionToFilter != 'all') {
            $divisionTeamsAPI.get({divisionId: $scope.divisionToFilter}, function (response) {
                $scope.synchronize(response.data);
                Notify(notifyMessage, notifyStatus);
            });
        } else {
            $leagueTeamsAPI.get({leagueId: leagueId}, function (response) {
                $scope.synchronize(response.data);
                Notify(notifyMessage, notifyStatus);
            });
        }
    };

    $scope.addTeamInModal = function() {
        loading();

        var teamName = $scope.teamName;
        var divisionId = $scope.divisionInAddTeamModal;
        var logo = $scope.fileread;

        $leaguesAPI.show({leagueId: leagueId}, function(league) {
            $teamsAPI.save({name: teamName, sport_id: league.data.sport_id, logo: logo} , function(team) {
                var teamId = team.data.id;

                $scope.teamName = '';
                $scope.divisionId = '';
                $scope.fileread = '';

                $leagueTeamsAPI.save({leagueId: leagueId, team_id: teamId}, function() {

                    if (divisionId != undefined) {
                        $divisionTeamsAPI.save({divisionId: divisionId, teams: [teamId]}, function() {
                            updateTeams('Team successfully added to the league', 'success');
                        });
                    } else {
                        updateTeams('Team successfully added to the league', 'success');
                    }
                });
            }, function(error) {
                loaded();
                Notify(error.data.error.message, 'error');
            });
        });
        $mdDialog.hide();
    };

    $scope.removeTeamInModal = function(teamId, teamName) {
        loading();
        $leagueTeamsAPI.delete({leagueId: leagueId, teamId: teamId}, function(response) {
            updateTeams('The team ' + teamName + ' was successfully deleted from the league', 'success');
        });

        $mdDialog.hide();
    };

    $scope.editTeamInModal = function(teamId) {
        loading();
        var teamNameToEdit = $scope.teamNameToEdit;
        var teamDivisionIdToEdit = $scope.teamDivisionIdToEdit;
        var logo = $scope.fileread;

        $teamsAPI.put({teamId: teamId, name: teamNameToEdit, logo: logo}, function() {

            $scope.teamNameToEdit = '';
            $scope.teamDivisionIdToEdit = '';
            $scope.fileread = '';

            if (teamDivisionIdToEdit != undefined) {
                $divisionTeamsAPI.save({divisionId: teamDivisionIdToEdit, teams: [teamId]}, function() {
                    updateTeams('The team ' + teamNameToEdit + ' was successfully updated', 'success');
                });
            } else {
                updateTeams('The team ' + teamNameToEdit + ' was successfully updated', 'success');
            }
        }, function(error) {
            loaded();
            Notify(error.data.error.message, 'error');
        });
        $mdDialog.hide();
    };

    $scope.addDivisionInModal = function() {
        loading();
        var divisionName = $scope.divisionName;

        $leagueDivisionsAPI.save({leagueId: leagueId, name: divisionName}, function() {
            $leagueDivisionsAPI.get({leagueId: leagueId}, function(response) {
                $scope.divisions = response.data;
                loaded();
                Notify('Division successfully added to the league', 'success');
            })
        });
        $mdDialog.hide();
    };

    $scope.editDivisionInModal = function(divisionId) {
        loading();
        var divisionNameToEdit = $scope.divisionNameToEdit;

        $leagueDivisionsAPI.put({leagueId: leagueId, divisionId: divisionId, name: divisionNameToEdit}, function() {
            $leagueDivisionsAPI.get({leagueId: leagueId}, function (response) {
                $scope.divisions = response.data;
                loaded();
                Notify('The division ' + divisionNameToEdit + ' was successfully updated', 'success');
            });
        });
        $mdDialog.hide();
    };

    $scope.removeDivisionInModal = function(divisionId, divisionName) {
        loading();

        $leagueDivisionsAPI.delete({leagueId: leagueId, divisionId: divisionId}, function() {
            $leagueDivisionsAPI.get({leagueId: leagueId}, function (response) {
                $scope.divisions = response.data;
                loaded();
                Notify('The division ' + divisionName + ' was successfully deleted from the league', 'success');
            });
        });
        $mdDialog.hide();
    };

    $scope.moveTeamsInModal = function() {
        loading();
        var teamsToMove = $scope.teamsToMove;
        var divisionIdToMove = $scope.divisionIdToMove;

        $divisionTeamsAPI.save({divisionId: divisionIdToMove, teams: teamsToMove}, function() {
            updateTeams('Teams successfully moved to the division', 'success');
        });
        $mdDialog.hide();
    };

}]);