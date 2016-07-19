/*
 * Created by Borges Diaz
 * User: borgdiaz
 * For: Dashboard
 * License: Wooter LLC.
 * Date: 2016.05.23
 * Description: Controller for dashboard page
 *
 */
__Wooter.controller('Dashboard/CreateSeasonController', ['$scope', '$mdDialog', '$stateParams', '$location', '$http', 'Page', 'Leagues', 'API', '$state', function ($scope, $mdDialog, $stateParams, $location, $http, Page, Leagues, API, $state) {
    
    /**********  INITIALIZATION  **********/
    
    //Redirect if league id is not present in the url
    
    if($stateParams.league_id === "" || !$stateParams.league_id){
        $state.go('404', {from: 'games'});
    }
    
    //Reset page
    
    Page.reset();
    
    //Style sheet definitions
    
    Page.stylesheets([
        '/css/dashboard/games-stats.css'
    ]);
    
    
    
    var getCreateSeasonRequest = function() {
        var createSeasonRequest = {};
    
        createSeasonRequest.leagueId = 1;
        createSeasonRequest.sportId = 3;
        createSeasonRequest.name = '';
        createSeasonRequest.startsAt = '';
        createSeasonRequest.endsAt = '';
        createSeasonRequest.registrationOpensAt = '';
        createSeasonRequest.registrationClosesAt = '';
        createSeasonRequest.maxTeams = '';
        createSeasonRequest.minTeams = '';
        createSeasonRequest.maxFreeAgents = '';
        createSeasonRequest.minFreeAgents = '';
        createSeasonRequest.price = '';
        
        return createSeasonRequest;
    };
    
    var sports = [
        {
            name : 'Football',
            id : 1
        },
        {
            name : 'Basketball',
            id : 3
        },
        {
            name : 'Softball',
            id : 8
        }
    ];
    
    var saveSeason = function(request) {
        $leagueSeasonsApi.save(request, saveSeasonResponse);
    };
    
    var saveSeasonResponse = function(response) {
        if (response.data) {
            $scope.createSeasonRequest = getCreateSeasonRequest();
            $$notify.create('The season has been successfully saved!');
        } else {
            //
        }
    };
    
    var $leagueSeasonsApi = API.exec('leagueSeasons');
    
    $scope.createSeasonRequest = getCreateSeasonRequest();
    $scope.sports = sports;
    $scope.saveSeason = saveSeason;
    
}]);
