/**
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Dashboard/players
 * License: Wooter LLC.
 * Date: 2016.02.10
 * Description:
 *
 */
__Wooter.controller('Dashboard/PlayersController', ['$scope', 'Page', '$stateParams', '$mdDialog', 'Notify', 'API', function ($scope, Page, $stateParams, $mdDialog, Notify, API) {

    loading();
    var $leaguesAPI = API.exec('leagues');
    var $leaguePlayersAPI = API.exec('leaguePlayers');
    var $leagueTeamsAPI = API.exec('leagueTeams');
    var $leagueSeasonsAPI = API.exec('leagueSeasons');
    
    var getPlayersRequest = function() {
        var request = {};
        request.leagueId = $stateParams.league_id;
        request.offset = 0;
        request.limit = 10;
        request.order_by = 'id';
        request.order_direction = 'DESC';
        
        return request;
    };
    
    var playersRequest = getPlayersRequest();

    /**
     * Get List of players
     */
    $leagueTeamsAPI.get({leagueId: $stateParams.league_id, all: true}, function (response) {
        $scope.teams = response.data.teams;
    });

    /**
     * Get List of players
     */
    $scope.items = [];
    $scope.selected = [];
    $leaguePlayersAPI.get(playersRequest, function (response) {
        $scope.synchronize(response.data);
    });

    $scope.synchronize = function(data) {
        $scope.players = data.players;
        $scope.pages = data.pages;

        $scope.items = [];
        $scope.selected = [];

        if ($scope.players instanceof Array) {
            $scope.players.forEach(function(player) {
                $scope.items.push(player.id);
            });
        } else {
            $scope.items.push($scope.players.id);
        }

        loaded();
    };

    $leaguesAPI.show({leagueId: $stateParams.league_id}, function (response) {
        $scope.league = response.data;
    });

    $leagueSeasonsAPI.get({leagueId: $stateParams.league_id}, function (response) {
        $scope.season = response.data[0];
    });

    /**
     * - Clean page (title, assets, favicon badge, etc.)
     * - Set Title Page
     */
    Page.reset();
    Page.title(getLeagueName() + ' - Players | Wooter');

    /**
     * Put here Action and Scopes
     */
    Page.stylesheets([
        '/css/dashboard/management.css',
        '/css/dashboard/animate.css',
        '/css/dashboard/players.css'
    ]);

    /**
     * Define League id
     */
    $scope.league_id = $stateParams.league_id;
    /**
     * Function method to get league name
     */
    function getLeagueName() {
        return "Dream Leagues Elite 8.5";
    }

    /**
     * Function method to get league subtitle
     */
    function getLeagueSubtitle() {
        return "Fall 2016";
    }

    $scope.leagueName = getLeagueName();
    $scope.leagueSubtitle = getLeagueSubtitle();
    $scope.teamToFilter = 'all';

    $scope.addPlayer = function ($event) {
        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Players'),
            templateUrl: 'views/default/modals/dashboard/players/add-player.html',
            parent: angular.element(document.body),
            scope: $scope,
            preserveScope: true,
            targetEvent: $event,
            clickOutsideToClose: true
        });
    };

    $scope.movePlayer = function ($event, player) {
        $event.stopPropagation();

        $scope.playerToMove = player;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Players'),
            templateUrl: 'views/default/modals/dashboard/players/move-player.html',
            parent: angular.element(document.body),
            scope: $scope,
            preserveScope: true,
            targetEvent: $event,
            clickOutsideToClose: true
        });
    };

    $scope.editPlayer = function ($event, player) {
        $event.stopPropagation();

        $scope.playerToEdit = player;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Players'),
            templateUrl: 'views/default/modals/dashboard/players/edit-player.html',
            parent: angular.element(document.body),
            scope: $scope,
            preserveScope: true,
            targetEvent: $event,
            clickOutsideToClose: true
        });
    };

    $scope.removePlayer = function ($event, player) {
        $event.stopPropagation();

        $scope.playerToDelete = player;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Players'),
            templateUrl: 'views/default/modals/dashboard/players/remove-player.html',
            parent: angular.element(document.body),
            scope: $scope,
            preserveScope: true,
            targetEvent: $event,
            clickOutsideToClose: true
        });
    };

    $scope.movePlayers = function(ev) {

        $scope.playersToMove = $scope.selected;

        $mdDialog.show({
            controller: getControllerName('Modals/Dashboard/Players'),
            templateUrl: logicTemplate('modals/dashboard/players/move-players'),
            scope: $scope,
            preserveScope: true,
            parent: angular.element(document.body),
            targetEvent: ev,
            clickOutsideToClose:true
        });
    };

    $scope.searchPlayers = function() {
        loading();

        playersRequest.q = $scope.search;
        playersRequest.offset = 0;

        $scope.playersIndex = 1;

        $leaguePlayersAPI.get(playersRequest, function (response) {
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
     * @param teamId
     */
    var getPlayersByTeamId = function(teamId) {
        loading();

        playersRequest.team_id = teamId;

        if (teamId == 'all') {
            delete playersRequest.team_id;
        }

        $leaguePlayersAPI.get(playersRequest, function (response) {
            $scope.synchronize(response.data);
        });
    };
    
    /**
     * Get players by offset
     * @param playersRequest
     * @param offset
     */
    var getPlayersByOffset = function(playersRequest, offset) {
        
        playersRequest.offset = offset;
        $leaguePlayersAPI.get(playersRequest, function (response) {
            $scope.synchronize(response.data);
        });
    };
    
    var playersOffset = 0;
    $scope.playersIndex = 1;
    
    /**
     * Navigate to the next page
     */
    var navNext  = function() {
        loading();

        $scope.playersIndex++;
        playersOffset += 10;
                
        getPlayersByOffset(playersRequest, playersOffset);
    };

    /**
     * Navigate to the last page
     */
    var navLast = function() {
        loading();

        $scope.playersIndex = $scope.pages;
        playersOffset = ($scope.pages * 10) - 10;
        
        getPlayersByOffset(playersRequest, playersOffset);
    };

    /**
     * Navigate to the previous page
     */
    var navPrev = function() {
        loading();

        $scope.playersIndex--;
        playersOffset -= 10;
        
        getPlayersByOffset(playersRequest, playersOffset);
    };

    /**
     * Navigate to the first page
     */
    var navFirst = function() {
        loading();

        $scope.playersIndex = 1;
        playersOffset = 0;
        
        getPlayersByOffset(playersRequest, playersOffset);
    };
    
    $scope.getPlayersByTeamId = getPlayersByTeamId;
    $scope.navNext = navNext;
    $scope.navLast = navLast;
    $scope.navPrev = navPrev;
    $scope.navFirst = navFirst;

}]);
