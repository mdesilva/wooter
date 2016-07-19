/*
 * Created by Carlos Marra
 * User: loslambda / los_lambdas
 * For: Dashboard/teams
 * License: Wooter LLC.
 * Date: 2016.03.18
 * Description:
 *
 */
__Wooter.controller('Dashboard/TeamsController', ['$scope','$mdDialog', 'Page', 'API', '$stateParams', function ($scope, $mdDialog, Page, API, $stateParams) {

    loading();
    var $leaguesAPI = API.exec('leagues');
    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $leagueDivisionsAPI = API.exec('leagueDivisions');
    var $leagueSeasonsAPI = API.exec('leagueSeasons');

    var getTeamsRequest = function() {
        var request = {};
        request.leagueId = $stateParams.league_id;
        request.offset = 0;
        request.limit = 10;
        request.order_by = 'id';
        request.order_direction = 'DESC';
        
        return request;
    };
    
    var teamsRequest = getTeamsRequest();

    $scope.divisionToFilter = 'all';

    /**
     * Get List of teams
     */
    $scope.fileread = false;
    $scope.items = [];
    $scope.selected = [];
    $leagueTeamsAPI.get(teamsRequest, function (response) {
        $scope.synchronize(response.data);
    });

    $scope.synchronize = function(data) {
        $scope.teams = data.teams;
        $scope.pages = data.pages;

        $scope.items = [];
        $scope.selected = [];

        if ($scope.teams instanceof Array) {
            $scope.teams.forEach(function(team) {
                $scope.items.push(team.id);
            });
        } else {
            $scope.items.push($scope.teams.id);
        }

        loaded();
    };

    /**
     * Get List of divisions
     */
    $leagueDivisionsAPI.get({leagueId: $stateParams.league_id}, function (response) {
        $scope.divisions = response.data;
    });


    /*
	 * - Clean page (title, assets, favicon badge, etc.)
	 * - Set Title Page
	 */
	Page.reset();
	Page.title(getLeagueName() + ' - Teams | Wooter');
    $scope.league_id = $stateParams.league_id;

    $leaguesAPI.show({leagueId: $stateParams.league_id}, function (response) {
        $scope.league = response.data;
    });

    $leagueSeasonsAPI.get({leagueId: $stateParams.league_id}, function (response) {
        $scope.season = response.data[0];
    });

    /*
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/management.css',
        '/css/dashboard/animate.css'
    ]);

    Page.scripts([
        '/js/dashboard/main_management.js'
    ]);

    /*
     * Define League id
     */


    /*
     * Function method to get league name
     */
    function getLeagueName(){
        return "Dream Leagues Elite 8.5";
    }

    /*
     * Function method to get league subtitle
     */
    function getLeagueSubtitle(){
        return "Fall 2016";
    }

    /*
     * Get Players by League id
     */

    $scope.leagueId = $stateParams.league_id;
    $scope.leagueName = getLeagueName();
    $scope.leagueSubtitle = getLeagueSubtitle();

    $scope.addTeam = function($event) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/add-team'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.editTeam = function($event, team) {
        $event.stopPropagation();

        $scope.teamNameToEdit = team.name;
        $scope.teamIdToEdit = team.id;

        angular.forEach(team.division, function(division) {
            if (division.league_id = $scope.leagueId) {
                $scope.teamDivisionIdToEdit = division.id;
            }
        });

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/edit-team'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.moveTeams = function($event) {

        $scope.teamsToMove = $scope.selected;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/move-teams'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.removeTeam = function($event, team) {
        $event.stopPropagation();

        $scope.teamNameToDelete = team.name;
        $scope.teamIdToDelete = team.id;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/remove-team'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.createDivision = function($event) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/add-division'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.editDivision = function($event, division) {

        $scope.divisionNameToEdit = division.name;
        $scope.divisionIdToEdit = division.id;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/edit-division'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.removeDivision = function($event, division) {

        $scope.divisionIdToDelete = division.id;
        $scope.divisionNameToDelete = division.name;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Teams'),
            templateUrl: logicTemplate('modals/dashboard/teams/remove-division'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true
        });
    };

    $scope.searchTeams = function() {
        loading();

        teamsRequest.q = $scope.search;
        teamsRequest.offset = 0;

        $scope.teamsIndex = 1;

        $leagueTeamsAPI.get(teamsRequest, function (response) {
            $scope.synchronize(response.data);
        });
    };

    $scope.toggle = function (item, list) {
        var idx = list.indexOf(item);
        if (idx > -1) {
            list.splice(idx, 1);
        }
        else {
            list.push(item);
        }
    };
    $scope.exists = function (item, list) {
        return list.indexOf(item) > -1;
    };
    $scope.isIndeterminate = function() {
        return ($scope.selected.length !== 0 &&
        $scope.selected.length !== $scope.items.length);
    };
    $scope.isChecked = function() {
        return $scope.selected.length === $scope.items.length;
    };
    $scope.toggleAll = function() {
        if ($scope.selected.length === $scope.items.length) {
            $scope.selected = [];
        } else if ($scope.selected.length === 0 || $scope.selected.length > 0) {
            $scope.selected = $scope.items.slice(0);
        }
    };
    
    /**
     * Get teams by division id
     * @param divisionId
     */
    
    var getTeamsByDivisionId = function(divisionId) {
        loading();

        $scope.divisionToFilter = divisionId;

        teamsRequest.division_id = divisionId;

        if (teamsRequest.division_id == 'all') {
            delete(teamsRequest.division_id);
        }
        
        $leagueTeamsAPI.get(teamsRequest, function (response) {
            $scope.synchronize(response.data);
        });
    };
    
    /**
     * Get teams by offset
     * @param teamsRequest
     * @param offset
     */
    
    var getTeamsByOffset = function(teamsRequest, offset) {
        
        teamsRequest.offset = offset;
        $leagueTeamsAPI.get(teamsRequest, function (response) {
            $scope.synchronize(response.data);
        });
    };
    
    var teamsOffset = 0;
    $scope.teamsIndex = 1;
    
    /**
     * Navigate to the next page
     */
    var navNext  = function() {
        $scope.teamsIndex++;
        teamsOffset += 10;
                
        getTeamsByOffset(teamsRequest, teamsOffset);
    };

    /**
     * Navigate to the last page
     */
    var navLast = function() {
        $scope.teamsIndex = $scope.pages;
        teamsOffset = ($scope.pages * 10) - 10;
        
        getTeamsByOffset(teamsRequest, teamsOffset);
    };

    /**
     * Navigate to the previous page
     */
    var navPrev = function() {
        $scope.teamsIndex--;
        teamsOffset -= 10;
        
        getTeamsByOffset(teamsRequest, teamsOffset);
    };

    /**
     * Navigate to the first page
     */
    var navFirst = function() {
        $scope.teamsIndex = 1;
        teamsOffset = 0;
        
        getTeamsByOffset(teamsRequest, teamsOffset);
    };
    
    $scope.getTeamsByDivisionId = getTeamsByDivisionId;
    $scope.navNext = navNext;
    $scope.navLast = navLast;
    $scope.navPrev = navPrev;
    $scope.navFirst = navFirst;

}]);

